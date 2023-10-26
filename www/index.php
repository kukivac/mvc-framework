<?php

ini_set('memory_limit', '-1');

use System\Core\Exceptions\RoutesException;
use system\core\helpers\Debug;
use System\Core\Helpers\Environment;
use System\Core\Routes\Router;

require("../vendor/autoload.php");
function autoloadFunction($class): void
{
    $classname = "./../" . str_replace("\\", "/", $class) . ".php";
    if (is_readable($classname)) {
        /** @noinspection */
        require($classname);
    }
}

spl_autoload_register("autoloadFunction");

Environment::setSystemEnvironment("dev");
switch (Environment::getSystemEnvironment()) {
    case Environment::DEV_ENVIROMENT:
        ini_set('error_reporting', E_ALL);
        break;
    case Environment::DEV_PRODUCTION:
        if (empty($_SERVER['HTTPS']) || $_SERVER['HTTPS'] == "off") {
            $redirect = 'https://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
            header('HTTP/1.1 301 Moved Permanently');
            header('Location: ' . $redirect);
            exit();
        }
        break;
}

ini_set('session.gc-maxlifetime', 1800);
mb_internal_encoding("UTF-8");
session_start();

$router = new Router();
try {
    $router->process([$_SERVER['REQUEST_URI']]);
} catch (RoutesException|Exception $e) {
    if (Environment::getSystemEnvironment() == Environment::DEV_ENVIROMENT) {
        Debug::dumpAndExit($e);
    }
    header($_SERVER['SERVER_PROTOCOL'] . ' 500 Internal Server Error', true, 500);
}