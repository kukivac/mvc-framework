<?php

namespace app\config;

use app\controllers\ArticlesAjaxController;
use app\controllers\ArticlesController;
use app\controllers\DefaultController;
use app\controllers\ErrorController;
use app\controllers\MaticeController;
use app\controllers\NewsAjaxController;
use app\controllers\NewsController;
use app\controllers\UserAjaxController;
use app\controllers\UserController;
use system\core\routes\Route;
use system\core\routes\Router;

class RoutesConfig
{
    /**
     * @var mixed[]
     */
    protected $routes = [
        "/" => [
            Route::CONTROLLER => [DefaultController::class, "getContentDefault"],
            Route::AUTHORIZATION => true,
        ],
        "matice" => [
            Route::CONTROLLER => [MaticeController::class, "getContentDefault"],
            Route::AUTHORIZATION => false,
        ],
        "user" => [
            "/" => [
                Route::CONTROLLER => [UserController::class, "getContentProfile"],
                Route::AUTHORIZATION => false,
            ],
            "profile" => [
                Route::CONTROLLER => [UserController::class, "getContentProfile"],
                Route::AUTHORIZATION => false,
            ],
            "login" => [
                Route::CONTROLLER => [UserController::class, "getContentLogin"],
                Route::AUTHORIZATION => false,
            ],
            "register" => [
                Route::CONTROLLER => [UserController::class, "getContentRegister"],
                Route::AUTHORIZATION => false,
            ],
            "logout" => [
                Route::CONTROLLER => [UserController::class, "getContentLogout"],
                Route::AUTHORIZATION => false,
            ],
            "ajax" => [
                "login" => [
                    Route::CONTROLLER => [UserAjaxController::class, "getContentLogin"],
                    Route::AUTHORIZATION => false,
                ],
                "register" => [
                    Route::CONTROLLER => [UserAjaxController::class, "getContentRegister"],
                    Route::AUTHORIZATION => false,
                ],
            ],
        ],
        "articles" => [
            "/" => [
                Route::CONTROLLER => [ArticlesController::class, "getContentDefault"],
                Route::AUTHORIZATION => false,
            ],
            "add" => [
                Route::CONTROLLER => [ArticlesController::class, "getContentCreateArticle"],
                Route::AUTHORIZATION => false,
            ],
            "ajax" => [
                "add" => [
                    Route::CONTROLLER => [ArticlesAjaxController::class, "getContentCreateArticle"],
                    Route::AUTHORIZATION => false,
                ],
                "delete" => [
                    Route::CONTROLLER => [ArticlesAjaxController::class, "getContentDeleteArticle"],
                    Route::AUTHORIZATION => false,
                ],
            ],
        ],
        "news" => [
            "/" => [
                Route::CONTROLLER => [NewsController::class, "getContentDefault"],
                Route::AUTHORIZATION => false,
            ],
            "add" => [
                Route::CONTROLLER => [NewsController::class, "getContentCreateNewsArticle"],
                Route::AUTHORIZATION => false,
            ],
            "ajax" => [
                "add" => [
                    Route::CONTROLLER => [NewsAjaxController::class, "getContentCreateNews"],
                    Route::AUTHORIZATION => false,
                ],
                "delete" => [
                    Route::CONTROLLER => [NewsAjaxController::class, "getContentDeleteNews"],
                    Route::AUTHORIZATION => false,
                ],
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
        if (Router::isKraken()) {
            return ["~kovacjaku" => $this->routes];
        } else {
            return $this->routes;
        }
    }
}