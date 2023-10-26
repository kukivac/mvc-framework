<?php
ini_set('memory_limit', '-1');

use System\Core\Exceptions\ControllerException;
use System\Core\Exceptions\RoutesException;
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
//@todo remove in production
$env = "dev";

ini_set('session.gc-maxlifetime', 1800);
ini_set('error_reporting', E_ALL);
mb_internal_encoding("UTF-8");

require("../vendor/autoload.php");

/**
 * @param $class
 * Class for autoload
 */
function autoloadFunction($class)
{
    $classname = "./../" . str_replace("\\", "/", $class) . ".php";
    if (is_readable($classname)) {
        /** @noinspection */
        require($classname);
    }
}

spl_autoload_register("autoloadFunction");
session_start();
$router = new Router();
try {
    $router->process(array($_SERVER['REQUEST_URI']));
} catch (ControllerException | RoutesException $e) {
    if($env =="dev"){
        echo $e->getMessage();
    }
    header($_SERVER['SERVER_PROTOCOL'] . ' 500 Internal Server Error', true, 500);
}