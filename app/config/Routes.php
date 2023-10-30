<?php

namespace app\config;

use app\controllers\DefaultController;
use app\controllers\ErrorController;
use app\controllers\MaticeController;
use system\core\Routes\RoutesConfig;

class Routes extends RoutesConfig
{
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @var mixed[]
     */
    protected array $routes = [
        "/" => [
            self::CONTROLLER => [DefaultController::class, "getContentDefault"],
            self::AUTHORIZATION => true,
        ],
        "matice" => [
            self::CONTROLLER => [MaticeController::class, "getContentDefault"],
            self::AUTHORIZATION => false,
        ],
        "karel" => [
            "prca" => [
                self::CONTROLLER => [DefaultController::class, "getContentDefault"],
                self::AUTHORIZATION => false,
            ],
            "kozu" => [
                self::CONTROLLER => [DefaultController::class, "getContentDefault"],
                self::AUTHORIZATION => false,
            ],
        ],
        "error" => [
            "400" => [
                self::CONTROLLER => [ErrorController::class, "error400"],
                self::AUTHORIZATION => false,
            ],
            "401" => [
                self::CONTROLLER => [ErrorController::class, "error401"],
                self::AUTHORIZATION => false,
            ],
            "404" => [
                self::CONTROLLER => [ErrorController::class, "error404"],
                self::AUTHORIZATION => false,
            ],
            "405" => [
                self::CONTROLLER => [ErrorController::class, "error405"],
                self::AUTHORIZATION => false,
            ],
            "410" => [
                self::CONTROLLER => [ErrorController::class, "error410"],
                self::AUTHORIZATION => false,
            ],
            "500" => [
                self::CONTROLLER => [ErrorController::class, "error500"],
                self::AUTHORIZATION => false,
            ],
        ],

    ];
}