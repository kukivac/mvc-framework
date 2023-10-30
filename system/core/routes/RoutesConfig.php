<?php

namespace system\core\Routes;

use system\core\exceptions\RoutesException;

class RoutesConfig
{
    public function __construct()
    {
    }

    /**
     * @var mixed[]
     */
    protected array $routes;

    private mixed $result;

    /**
     * @param mixed $needle
     *
     * @return mixed
     * @throws RoutesException
     */
    public function getRoutes(mixed $needle): mixed
    {
        $this->sanitizeConfig();
        if (isset($this->routes[$needle])) {
            $this->setResult($this->routes[$needle]);
            $this->validateResult();

            return $this->getResult();
        } else {
            return false;
        }
    }

    /**
     * @return void
     * @throws RoutesException
     */
    private function sanitizeConfig(): void
    {
        foreach ($this->routes as $key => $route) {
            $pattern = "[a-Z]";
            if (preg_match($pattern, $key)) {
                unset($this->routes[$key]);
            }
            if (file_exists('../app/controllers/' . $key . 'Controller.php')) {
                throw new RoutesException("Route contains existing controller, thus overriding it.");
            }
        }
    }

    /**
     * @param mixed $result
     */
    public function setResult(mixed $result): void
    {
        $this->result = $result;
    }

    /**
     * @throws RoutesException
     */
    private function validateResult(): void
    {
        if (!is_array($this->result)) {
            throw new RoutesException("Route is not properly defined");
        }
        foreach ($this->result as $item) {
            if (!is_string($item)) {
                throw new RoutesException("Route is not properly defined");
            }
        }
    }

    /**
     * @return mixed
     */
    public function getResult(): mixed
    {
        return $this->result;
    }
}