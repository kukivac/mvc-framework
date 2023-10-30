<?php

namespace system\core\Routes;

use system\core\exceptions\RoutesException;
use system\core\helpers\Format;

class RoutesConfig
{
    const CONTROLLER = "controller";
    const AUTHORIZATION = "authorization";

    public function __construct()
    {
    }

    /** @var mixed[] */
    protected array $routes;

    /** @var string[] */
    private array $result;

    /**
     * @param string[] $parameters
     * @param mixed[]|null $routes
     * @return Route
     * @throws RoutesException
     */
    public function getRoute(array $parameters, array $routes = null): Route
    {
        if ($routes === null) {
            $routes = $this->routes;
        }
        $current_param = array_shift($parameters);
        $route = $routes[$current_param] ?? null;
        if ($route === null) {
            throw new RoutesException("Route " . $current_param . " could not be found.");
        }
        if (Format::isArrayOfArrays($route)) {
            $found_route = $this->getRoute($parameters, $route);
        } else {
            if (count($parameters) !== 0) {
                throw new RoutesException("There are remaining parts of the url, but they could not be found in Routes");
            }
            $route_authorization = $route[self::AUTHORIZATION] ?? false;
            $found_route = new Route($route[self::CONTROLLER], $route_authorization);
        }

        return $found_route;
    }

    /**
     * Does not work now, @param mixed[]|null $routes
     * @return void
     * @throws RoutesException
     * @todo later
     */
    public function sanitizeConfig(array $routes = null): void
    {
        if ($routes === null) {
            $routes = $this->routes;
        }
        foreach ($routes as $key => $route) {
            if (Format::isArrayOfArrays($route)) {
                $this->sanitizeConfig($route);
            }
            if (!isset($route[self::CONTROLLER]) || !is_callable($route[self::CONTROLLER], true)) {
                throw new RoutesException("Route " . $key . " has no controller set in its definition");
            }
            $pattern = "[a-Z]";
            if (preg_match($pattern, $key)) {
                throw new RoutesException("Route " . $key . " contains non allowed values.");
            }
            if (!class_exists($route[RoutesConfig::CONTROLLER][0])) {
                throw new RoutesException("Routes " . $key . " specified controller, does not exist.");
            }
        }
    }

    /**
     * @param string $needle
     * @return string[]|null
     */
    public function getSingleRoute(string $needle): ?array
    {
        return $this->routes[$needle] ?? null;
    }
}