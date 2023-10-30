<?php

namespace app\controllers;

use system\core\controllers\ViewController;

/**
 * Controller DefaultController
 *
 * @package app\controllers
 */
class DefaultController extends ViewController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function getContentDefault(): void
    {
        $this->head->addMeta("description", "Homepage of website");
        $this->head->addMeta("keywords", "homepage,home");
        $this->head->addTitle("Homepage");
        $this->setView('default');
    }
}