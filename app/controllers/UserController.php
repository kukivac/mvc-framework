<?php

declare(strict_types=1);

namespace app\controllers;

use system\core\controllers\ViewController;
use system\core\Routes\Router;

class UserController extends ViewController
{
    public function __construct(bool $active = true)
    {
        parent::__construct($active);
    }

    /**
     * @param mixed[] $query
     * @return void
     */
    public function getContentProfile(array $query): void
    {
        /** Profil už se mi nechtěl dělat */
        Router::reroute("/");
        //        if (!$this->isLoggedInUser()) {
        //            Router::reroute("user/login");
        //        }
        //        $this->assign("title", "Profile");
        //        $this->setView('user.profile');
    }

    /**
     * @param mixed[] $query
     * @return void
     */
    public function getContentDefault(array $query): void
    {
        /** Profil už se mi nechtěl dělat */
        Router::reroute("/");
        //        if (!$this->isLoggedInUser()) {
        //            Router::reroute("user/login");
        //        }
        //        Router::reroute("user/profile");
    }

    /**
     * @param mixed[] $query
     * @return void
     */
    public function getContentLogin(array $query): void
    {
        if ($this->isLoggedInUser()) {
            Router::reroute("/");
        }
        $this->assign("title", "Login");
        $this->setView('user.login');
    }

    /**
     * @param mixed[] $query
     * @return void
     */
    public function getContentRegister(array $query): void
    {
        if ($this->isLoggedInUser()) {
            Router::reroute("/");
        }
        $this->assign("title", "Register");
        $this->setView('user.register');
    }

    public function getContentLogout(array $query)
    {
        $this->loggoutUser();
        Router::reroute(getLink("/user/login"));
    }
}