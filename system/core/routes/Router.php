<?php

namespace system\core\Routes;

require(__DIR__ . "/../../../vendor/autoload.php");

use app\config\RoutesConfig;
use PDOException;
use system\core\AbstractController;
use system\core\exceptions\ControllerException;
use system\core\exceptions\RoutesException;
use system\core\helpers\Environment;
use system\core\helpers\Format;
use system\core\user\User;
use system\database\Database;

/**
 * Router
 *
 * @package app\router
 */
final class Router
{
    /** @var mixed[] */
    protected $routes;

    /**
     * @var AbstractController $data
     */
    private $controller;

    /** @var string[] */
    private $parameters;

    /** @var mixed[] */
    private $query;

    public function __construct()
    {
        $routes_config = new RoutesConfig();
        $this->routes = $routes_config->getRoutes();
    }

    /**
     * @param string $request_uri
     *
     * @throws ControllerException
     */
    public function process(string $request_uri): void
    {
        $user = $this->processUser();
        /* Database connection tryout */
        $this->testDatabaseConnection();
        /* URL Parsing */
        $this->parseURL($request_uri);
        /** Try custom routes */
        try {
            $route = $this->getRoute($this->parameters);
        } catch (RoutesException $exception) {
            $this->process("error/404");
            exit();
        }
        $controllerName = $route->getControllerName();
        /** @var AbstractController $controllerClass */
        $controllerClass = new $controllerName;
        $this->controller = $controllerClass;
        $this->controller->setControllerName(str_replace("Controller", "", array_reverse(explode("\\", $controllerName))[0]));
        if ($user !== null) {
            $this->controller->setLoggedInUser($user);
        }
        if ($this->controller->isActive()) {
            $callback = [$controllerClass, $route->getControllerMethod()];
            if (is_callable($callback)) {
                call_user_func($callback, $this->query);
                $this->controller->build();
            } else {
                $this->process("error/500");
                exit();
            }
        } else {
            $this->process("/");
            exit();
        }
    }

    /**
     * @param string $url
     *
     * @return void
     * @throws ControllerException
     */
    private function parseURL(string $url): void
    {
        $urlComponents = parse_url($url);
        if (!is_array($urlComponents) || !isset($urlComponents['path'])) {
            throw new ControllerException("Url parameter path is not present.");
        }
        $parsedURL = ltrim($urlComponents["path"], "/");
        $parsedURL = trim($parsedURL);
        $parsedURL = explode("/", $parsedURL);
        $parameters = [];
        foreach ($parsedURL as $parse) {
            if ($parse !== '') {
                $parameters[] = $parse;
            } else {
                break;
            }
        }
        if (count($parameters) === 0) {
            array_unshift($parameters, "/");
        }
        $this->setParameters($parameters);
        $query = [];
        if (isset($urlComponents["query"])) {
            parse_str($urlComponents["query"], $query);
        }
        $this->setQuery($query);
    }

    /**
     * @param string $url
     * @param mixed[] $queryParameters
     *
     * @return void
     */
    static function reroute(string $url, array $queryParameters = []): void
    {
        $url = getLink($url);
        if (!empty($queryParameters)) {
            $url .= "?" . http_build_query($queryParameters);
        }
        if (substr($url, 0, 1) === '/') {
            $url = ltrim($url, '/');
        }
        header("Location: /$url");
        header("Connection: close");
        exit;
    }

    /**
     * @return bool
     */
    static function isKraken(): bool
    {
        return $_SERVER['HTTP_HOST'] === "kraken.pedf.cuni.cz";
    }

    /**
     * @param string[] $parameters
     */
    private function setParameters(array $parameters): void
    {
        $this->parameters = $parameters;
    }

    /**
     * @param mixed[] $query
     */
    private function setQuery(array $query): void
    {
        $this->query = $query;
    }

    /**
     * @return void
     * @throws ControllerException
     */
    private function testDatabaseConnection(): void
    {
        if (!isset($_SESSION["database"])) {
            $this->writeDatabaseFlag();
        } elseif (($_SESSION["database"] + 7200) < time()) {
            $this->writeDatabaseFlag();
        }
    }

    /**
     * @return void
     * @throws ControllerException
     */
    private function writeDatabaseFlag(): void
    {
        if ($this->testDatabaseObject()) {
            $_SESSION["database"] = time();
        } else {
            if (Environment::useDatabase()) {
                if ($this->parameters[0] != "error") {
                    $this->process("error/500");
                }
            }
        }
    }

    /**
     * @return bool
     */
    private function testDatabaseObject(): bool
    {
        try {
            new Database();

            return true;
        } catch
        (PDOException $exception) {
            return false;
        }
    }

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
        if ($current_param == null) {
            $current_param = "/";
        }
        $route = $routes[$current_param] ?? null;
        if ($route === null) {
            throw new RoutesException("Route " . $current_param . " could not be found.");
        }
        /** @var mixed[] $route */
        if (Format::isArrayOfArrays($route)) {
            $found_route = $this->getRoute($parameters, $route);
        } else {
            if (count($parameters) !== 0) {
                throw new RoutesException("There are remaining parts of the url, but they could not be found in Routes");
            }
            /** @var bool $route_authorization */
            $route_authorization = $route[Route::AUTHORIZATION] ?? false;
            $found_route = new Route($route[Route::CONTROLLER], $route_authorization);
        }

        return $found_route;
    }

    /**
     * Does not work now,
     * @param mixed[]|null $routes
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
            /** @var mixed[] $route */
            if (Format::isArrayOfArrays($route)) {
                $this->sanitizeConfig($route);
            }
            if (!isset($route[Route::CONTROLLER]) || !is_callable($route[Route::CONTROLLER], true)) {
                throw new RoutesException("Route " . $key . " has no controller set in its definition");
            }
            $pattern = "[a-Z]";
            if (preg_match($pattern, $key)) {
                throw new RoutesException("Route " . $key . " contains non allowed values.");
            }
            /** @var string[] $route_controller */
            $route_controller = $route[Route::CONTROLLER];
            if (!class_exists($route_controller[0])) {
                throw new RoutesException("Routes " . $key . " specified controller, does not exist.");
            }
        }
    }

    /**
     * @return User|null
     */
    private function processUser(): ?User
    {
        if (!array_key_exists('user', $_SESSION)) {
            $_SESSION['user'] = null;
        }

        return $_SESSION['user'];
    }
}
