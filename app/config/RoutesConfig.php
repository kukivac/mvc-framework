<?php

namespace app\config;

use app\controllers\DefaultController;
use app\controllers\ErrorController;
use app\controllers\MaticeController;
use system\core\Routes\Route;

class RoutesConfig
{
    /**
     * @var mixed[]
     */
    protected array $routes = [
        "/" => [
            Route::CONTROLLER => [DefaultController::class, "getContentDefault"],
            Route::AUTHORIZATION => true,
        ],
        "matice" => [
            Route::CONTROLLER => [MaticeController::class, "getContentDefault"],
            Route::AUTHORIZATION => false,
        ],
        "karel" => [
            "prca" => [
                Route::CONTROLLER => [DefaultController::class, "getContentDefault"],
                Route::AUTHORIZATION => false,
            ],
            "kozu" => [
                Route::CONTROLLER => [DefaultController::class, "getContentDefault"],
                Route::AUTHORIZATION => false,
            ],
        ],
        "error" => [
            "400" => [
                Route::CONTROLLER => [ErrorController::class, "error400"],
                Route::AUTHORIZATION => false,
            ],
            "401" => [
                Route::CONTROLLER => [ErrorController::class, "error401"],
                Route::AUTHORIZATION => false,
            ],
            "404" => [
                Route::CONTROLLER => [ErrorController::class, "error404"],
                Route::AUTHORIZATION => false,
            ],
            "405" => [
                Route::CONTROLLER => [ErrorController::class, "error405"],
                Route::AUTHORIZATION => false,
            ],
            "410" => [
                Route::CONTROLLER => [ErrorController::class, "error410"],
                Route::AUTHORIZATION => false,
            ],
            "500" => [
                Route::CONTROLLER => [ErrorController::class, "error500"],
                Route::AUTHORIZATION => false,
            ],
        ],
    ];

    /**
     * @return mixed[]
     */
    public function getRoutes(): array
    {
        return $this->routes;
    }
}