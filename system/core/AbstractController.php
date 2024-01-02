<?php

namespace system\core;

use system\core\exceptions\ControllerException;
use system\core\user\User;
use Transliterator;

/**
 * Class Controller
 *
 * @package app\controllers
 */
abstract class AbstractController
{
    /** @var string */
    protected $controllerName;

    /** @var bool */
    protected $active;

    /** @var User|null */
    protected $user = null;

    /**
     * Controller constructor.
     *
     * @param bool $active
     */
    public function __construct(bool $active = true)
    {
        $this->active = $active;
    }

    /**
     * @throws ControllerException
     */
    abstract function build(): void;

    /**
     * @return void
     */
    public final function setInactive(): void
    {
        $this->active = false;
    }

    /**
     * @return bool
     */
    public final function isActive(): bool
    {
        return $this->active;
    }

    /**
     * @param string $controllerName
     */
    public final function setControllerName(string $controllerName): void
    {
        $this->controllerName = $controllerName;
    }

    /**
     * @param User|null $user
     * @param bool $set_to_session
     * @return void
     */
    public final function setLoggedInUser(?User $user, bool $set_to_session = false)
    {
        $this->user = $user;

        if ($set_to_session) {
            $_SESSION["user"] = $user;
        }
    }

    /**
     * @return bool
     */
    public final function isLoggedInUser(): bool
    {
        return $this->user instanceof User;
    }

    public final function isAdmin(): bool
    {
        if ($this->isLoggedInUser()) {
            return $this->user->getUserLevel()->getName() === User::ROLE_ADMIN;
        } else {
            return false;
        }
    }

    public function getLoggedInUserId()
    {
        if ($this->isLoggedInUser()) {
            return $this->user->getId();
        } else {
            return null;
        }
    }

    public final function loggoutUser()
    {
        $this->setLoggedInUser(null, true);
    }

    /**
     * Convert standard names to dash-based style
     *
     * @param string $argument
     *
     * @return string
     * @throws ControllerException
     */
    public function basicToDash(string $argument): string
    {
        $transliterator = Transliterator::createFromRules(':: Any-Latin; :: Latin-ASCII; :: NFD; :: [:Nonspacing Mark:] Remove; :: Lower(); :: NFC;', Transliterator::FORWARD);
        if ($transliterator === null) {
            throw new ControllerException('Could not create instance of $transliterator');
        }
        if (!($transliteratedResult = $transliterator->transliterate($argument))) {
            throw new ControllerException("Could not transliterate argument: " . $argument);
        }
        $replaced_result = preg_replace("[\W+]", "-", $transliteratedResult);
        if (!is_string($replaced_result)) {
            throw new ControllerException("Result of preg_replace is not string");
        }

        return $replaced_result;
    }
}
