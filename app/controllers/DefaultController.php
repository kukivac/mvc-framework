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

    /**
     * Sets default homepage
     *
     * @param array $params
     * @param array|null $query
     *
     * @return void
     */
    public function process(array $params, array $query = null)
    {
        $this->head->addMeta("description", "Homepage of website");
        $this->head->addMeta("keywords", "homepage,home");
        $this->head->addTitle("Homepage");
        $this->setView('default');
    }
}