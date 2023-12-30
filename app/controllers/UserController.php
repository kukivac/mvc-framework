<?php

declare(strict_types=1);

namespace app\controllers;

use system\core\controllers\ViewController;
use system\core\Routes\Router;

class UserController extends ViewController
{
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @param mixed[] $query
     * @return void
     */
    public function getContentProfile(array $query): void
    {
        if (!$this->isLoggedInUser()) {
            Router::reroute("user/login");
        }
        $this->data['title'] = "Login";
        $this->setView('user.profile');
    }

    /**
     * @param mixed[] $query
     * @return void
     */
    public function getContentDefault(array $query): void
    {
        if (!$this->isLoggedInUser()) {
            Router::reroute("user/login");
        }
        Router::reroute("user/profile");
    }

    /**
     * @param mixed[] $query
     * @return void
     */
    public function getContentLogin(array $query): void
    {
        $this->data['title'] = "Login";
        $this->setView('user.login');
    }

    /**
     * @param mixed[] $query
     * @return void
     */
    public function getContentRegister(array $query): void
    {
        $this->data['title'] = "Register";
        $this->setView('user.register');
    }
}