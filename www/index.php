<?php

ini_set('memory_limit', '-1');

use JetBrains\PhpStorm\NoReturn;
use System\Core\Exceptions\ControllerException;
use System\Core\Exceptions\RoutesException;
use System\Core\Helpers\Enviroment;
use System\Core\Routes\Router;

//@todo remove on webserver
/*
if (empty($_SERVER['HTTPS']) || $_SERVER['HTTPS'] == "off") {
    $redirect = 'https://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
    header('HTTP/1.1 301 Moved Permanently');
    header('Location: ' . $redirect);
    exit();
}
*/

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
//@todo remove in production
$env = Enviroment::getSystemEnviroment();
if ($env === Enviroment::DEV_ENVIROMENT) {
    ini_set('error_reporting', E_ALL);
}

ini_set('session.gc-maxlifetime', 1800);
mb_internal_encoding("UTF-8");
/**
 * @param $class
 * Class for autoload
 */

#[NoReturn] function dd(...$variables): void
{
    echo '<pre>';
    var_dump(...$variables);
    echo '</pre>';
    die();
}

session_start();
$router = new Router();
try {
    $router->process([$_SERVER['REQUEST_URI']]);
} catch (ControllerException|RoutesException $e) {
    if (Enviroment::getSystemEnviroment() == "dev") {
        echo $e->getMessage();
    }
    header($_SERVER['SERVER_PROTOCOL'] . ' 500 Internal Server Error', true, 500);
}