<?php

namespace system\core\Routes;

use Exception;
use system\core\exceptions\RoutesException;

class Routes
{
    /**
     * @param string $parameter
     *
     * @return string[]|false
     * @throws RoutesException
     */
    public static function tryRoute(string $parameter): false|array
    {
        try {
            $routes = new \app\config\Routes();
        } catch (Exception $exception) {
            return false;
        }

        return $routes->getRoutes($parameter);
    }
}