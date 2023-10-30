<?php

namespace system\core\Routes;

require(__DIR__ . "/../../../vendor/autoload.php");

use JetBrains\PhpStorm\NoReturn;
use PDOException;
use system\core\AbstractController;
use system\core\exceptions\ControllerException;
use system\core\exceptions\RoutesException;
use system\core\helpers\Format;
use system\database\Database;
use Tracy\Debugger;

/**
 * Router
 *
 * @package app\router
 */
final class Router
{
    /**
     * @var AbstractController $data
     */
    private AbstractController $controller;

    /** @var string[] */
    private array $parameters;

    /** @var mixed[] */
    private array $query;

    /**
     * @param string $request_uri
     *
     * @throws RoutesException
     * @throws ControllerException
     */
    public function process(string $request_uri): void
    {
        /* Database connection tryout */
        $this->testDatabaseConnection();
        /* URL Parsing */
        $this->parseURL($request_uri);
        /** Try custom routes */
        $routesResult = Routes::tryRoute($this->parameters[0]);
        if (Format::isArrayOfStrings($routesResult)) {
            /** @var string[] $routesResult */
            $this->insertNewRoute($routesResult);
        }

        $dashControllerName = array_shift($this->parameters);
        if ($dashControllerName === null) {
            throw new ControllerException("There isnt any parameter in parameters array");
        }
        /* Controller name init */
        $controllerName = $this->dashToCamel($dashControllerName);
        /* Controller class init */
        if (file_exists('../app/controllers/' . $controllerName . 'Controller.php')) {
            $controllerClassName = "\app\controllers\\" . $controllerName . 'Controller';
            /** @var AbstractController $controllerClass */
            $controllerClass = new $controllerClassName;
            $this->controller = $controllerClass;
        } else {
            $this->reroute('error/404');
        }
        /* Controller preparing*/
        $this->controller->setControllerName($controllerName);
        if ($this->controller->isActive()) {
            $this->controller->build($this->parameters, $this->query);
        } else {
            $this->reroute("default");
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
        if (empty($parameters[0])) {
            array_unshift($parameters, "default");
        }
        $this->setParameters($parameters);
        $query = [];
        if (isset($urlComponents["query"])) {
            parse_str($urlComponents["query"], $query);
        }
        $this->setQuery($query);
    }

    /**
     * @param string $text
     *
     * @return string
     */
    private function dashToCamel(string $text): string
    {
        return str_replace(' ', '', ucwords(str_replace('-', ' ', $text)));
    }

    /**
     * @param string $url
     * @param mixed[] $queryParameters
     *
     * @return void
     */
    #[NoReturn] static function reroute(string $url, array $queryParameters = []): void
    {
        if (!empty($queryParameters)) {
            $url .= "?" . http_build_query($queryParameters);
        }
        header("Location: /$url");
        header("Connection: close");
        exit;
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
     */
    private function writeDatabaseFlag(): void
    {
        if ($this->testDatabaseObject()) {
            $_SESSION["database"] = time();
        } else {
            Debugger::log("Error with Database test");
            if ($this->parameters[0] != "error") {
                $this->reroute("/error/500");
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
        (PDOException) {
            return false;
        }
    }

    /**
     * @param string[] $routesResult
     * @return void
     */
    private function insertNewRoute(array $routesResult)
    {
        $this->setParameters($routesResult);
    }
}
