<?php

ini_set('memory_limit', '-1');

use system\core\helpers\Environment;
use system\core\helpers\SystemEnvironments;
use system\core\Routes\Router;
use Tracy\Debugger;

require("../vendor/autoload.php");

Debugger::enable();
Debugger::$logDirectory = __DIR__ . '\..\log';
function autoloadFunction(string $class): void
{
    $classname = "./../" . str_replace("\\", "/", $class) . ".php";
    if (is_readable($classname)) {
        /** @noinspection */
        require($classname);
    }
}

spl_autoload_register("autoloadFunction");

Environment::setSystemEnvironment(SystemEnvironments::DEVELOPMENT);
switch (Environment::getSystemEnvironment()) {
    case SystemEnvironments::DEVELOPMENT:
        ini_set('error_reporting', E_ALL);
        break;
    case SystemEnvironments::PRODUCTION:
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
$router->process($_SERVER['REQUEST_URI']);
