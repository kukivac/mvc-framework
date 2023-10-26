<?php

namespace System\Core\Routes;

use Exception;
use System\Core\Exceptions\RoutesException;

class Routes
{
    /**
     * @param mixed $parameter
     *
     * @return array|bool
     * @throws RoutesException
     */
    public static function tryRoute(mixed $parameter): bool|array
    {
        try {
            $routes = new \app\Config\Routes();
        } catch (Exception) {
            return false;
        }

        return $routes->getRoutes($parameter);
    }
}