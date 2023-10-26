<?php

namespace System\Core\Routes;

require(__DIR__ . "/../../../vendor/autoload.php");

use JetBrains\PhpStorm\NoReturn;
use PDOException;
use System\Core\AbstractController;
use System\Core\Exceptions\RoutesException;
use System\Database\Database;

/**
 * Router
 *
 * @package App\router
 */
final class Router
{
    /**
     * @var AbstractController $data
     */
    private AbstractController $controller;

    private array $parameters;

    private array $query;

    /**
     * @param $params
     *
     * @throws RoutesException
     */
    public function process($params): void
    {
        /* URL Parsing */
        $this->parseURL($params[0]);
        /* Database connection tryout */
        $this->testDatabaseConnection();

        if ($routesResult = Routes::tryRoute($this->parameters[0])) {
            $this->insertNewRoute($routesResult);
        }

        /* Controller name init */
        $controllerName = $this->dashToCamel(array_shift($this->parameters));
        /* Controller class init */
        if (file_exists('../app/controllers/' . $controllerName . 'Controller.php')) {
            $controllerClass = "\app\Controllers\\" . $controllerName . 'Controller';
            $this->controller = new $controllerClass;
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
     */
    private function parseURL(string $url): void
    {
        $url = parse_url($url);
        $parsedURL = ltrim($url["path"], "/");
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
        if (isset($url["query"])) {
            parse_str($url["query"], $query);
        }
        $this->setQuery($query);
    }

    /**
     * @param string $text
     *
     * @return string
     */
    private function dashToCamel(string $text)
    {
        return str_replace(' ', '', ucwords(str_replace('-', ' ', $text)));
    }

    /**
     * @param string $url
     * @param array $parameters
     *
     * @return void
     */
    #[NoReturn] static function reroute(string $url, array $parameters = []): void
    {
        $url = "/" . $url;
        if (!empty($parameters)) {
            $url .= "?" . http_build_query($parameters);
        }
        header("Location: /$url");
        header("Connection: close");
        exit;
    }

    /**
     * @param array $parameters
     */
    private function setParameters(array $parameters): void
    {
        $this->parameters = $parameters;
    }

    /**
     * @param array $query
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
            if ($this->parameters[0] != "error") {
                $this->reroute("error/500");
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

    private function insertNewRoute(array|bool $routesResult)
    {
        $this->setParameters($routesResult);
    }
}
