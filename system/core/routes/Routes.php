<?php

namespace system\core\Routes;

use Exception;
use system\core\exceptions\RoutesException;

class Routes
{
    /**
     * @param string[] $parameters
     * @return Route
     * @throws RoutesException
     */
    public static function findRoute(array $parameters): Route
    {
        $routes = new \app\config\Routes();

        //        $routes->sanitizeConfig();

        return $routes->getRoute($parameters);
    }
}