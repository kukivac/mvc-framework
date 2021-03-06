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

    /**
     * Sets view by error code
     *
     * @param array      $params
     * @param array|null $query
     *
     * @return void
     */
    public function process(array $params, array $query = null)
    {
        if (isset($params[0])) {
            $errorCode = $params[0];
            $file = "../app/views/Error/" . $errorCode . ".latte";
            $errorCode = is_file($file) ? $errorCode : "400";
            call_user_func("error" . $errorCode);
        } else {
            $errorCode = "404";
        }
        $this->head->addMeta("description", "Error occured");
        $this->head->addMeta("keywords", "error");
        $this->head->addTitle("Error " . $errorCode);
        $this->setView($errorCode);
    }

    public function error400()
    {
        $this->head->addMeta("description", "Bad request");
        $this->head->addMeta("keywords", "error,bad,request,400");
        $this->head->addTitle("Error 400");
        $this->setView("400");
    }

    public function error401()
    {
        $this->head->addMeta("description", "Unauthorized");
        $this->head->addMeta("keywords", "error,unauthorized,401");
        $this->head->addTitle("Error 401");
        $this->setView("401");
    }

    public function error404()
    {
        $this->head->addMeta("description", "Page not found");
        $this->head->addMeta("keywords", "error,404");
        $this->head->addTitle("Error 404");
        $this->setView("404");
    }

    public function error405()
    {
        $this->head->addMeta("description", "Error occured");
        $this->head->addMeta("keywords", "error");
        $this->head->addTitle("Error 405");
        $this->setView("405");
    }

    public function error410()
    {
        $this->head->addMeta("description", "Error occured");
        $this->head->addMeta("keywords", "error");
        $this->head->addTitle("Error 410");
        $this->setView("410");
    }

    public function error500()
    {
        $this->head->addMeta("description", "Error occured");
        $this->head->addMeta("keywords", "error");
        $this->head->addTitle("Error 500");
        $this->setView("500");
    }
}
