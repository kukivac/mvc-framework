<?php


namespace system\core\Routes;


use Exception;
use system\core\exceptions\RoutesException;

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
            $routes = new \app\config\Routes();
        }catch (Exception){
            return false;
        }
        return $routes->getRoutes($parameter);
    }
}