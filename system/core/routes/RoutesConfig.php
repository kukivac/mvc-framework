<?php

namespace system\core\Routes;

use system\core\exceptions\RoutesException;

class RoutesConfig
{
    public function __construct()
    {
    }

    /** @var string[][] */
    protected array $routes;

    /** @var string[] */
    private array $result;

    /**
     * @param string $needle
     *
     * @return string[]|false
     * @throws RoutesException
     */
    public function getRoutes(string $needle): false|array
    {
        $this->sanitizeConfig();
        $custom_route = $this->getRoute($needle);
        if ($custom_route !== null) {
            $this->setResult($custom_route);
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
     * @param string[] $result
     */
    public function setResult(array $result): void
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
     * @return string[]
     */
    public function getResult(): array
    {
        return $this->result;
    }

    /**
     * @param string $needle
     * @return string[]|null
     */
    public function getRoute(string $needle): ?array
    {
        return $this->routes[$needle] ?? null;
    }
}