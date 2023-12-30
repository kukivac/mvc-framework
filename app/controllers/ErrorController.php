<?php

namespace app\controllers;

use system\core\controllers\ViewController;

/**
 * Controller ErrorController
 *
 * @package app\controllers
 */
class ErrorController extends ViewController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function error400(): void
    {
        $this->setView("error.400");
    }

    public function error401(): void
    {
        $this->setView("error.401");
    }

    public function error404(): void
    {
        $this->setView("error.404");
    }

    public function error405(): void
    {
        $this->setView("error.405");
    }

    public function error410(): void
    {
        $this->setView("error.410");
    }

    public function error500(): void
    {
        $this->setView("error.500");
    }
}
