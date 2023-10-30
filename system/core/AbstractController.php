<?php

namespace system\core;

use system\core\exceptions\ControllerException;
use Transliterator;

/**
 * Class Controller
 *
 * @package app\controllers
 */
abstract class AbstractController
{
    /** @var string */
    protected string $controllerName;

    /** @var bool */
    protected bool $active;

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
     * Definition of process function for inheritance
     *
     * @param string[] $parameters
     * Main url parameters
     * @param mixed[]|null $query
     * Get parameters from url
     */
    abstract function process(array $parameters, array $query = null): void;

    /**
     * Definition of process function for inheritance
     *
     * @param string[] $parameters
     * @param mixed[]|null $query
     * @throws ControllerException
     */
    abstract function build(array $parameters, array $query = null): void;

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
     * Convert standard names to dash-based style
     *
     * @param string $argument
     *
     * @return string
     */
    public function basicToDash(string $argument): string
    {
        $transliterator = Transliterator::createFromRules(':: Any-Latin; :: Latin-ASCII; :: NFD; :: [:Nonspacing Mark:] Remove; :: Lower(); :: NFC;', Transliterator::FORWARD);

        return preg_replace("[\W+]", "-", $transliterator->transliterate($argument));
    }
}
