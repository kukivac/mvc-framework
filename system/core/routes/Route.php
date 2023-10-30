<?php

declare(strict_types=1);

namespace system\core\Routes;

class Route
{
    /** @var string[] */
    private array $controller;

    /** @var bool */
    private bool $authorization;

    /**
     * @param string[] $controller
     * @param bool $authorization
     */
    public function __construct(array $controller, bool $authorization)
    {
        $this->controller = $controller;
        $this->authorization = $authorization;
    }

    public function getControllerName()
    {
        return $this->controller[0];
    }

    public function getControllerMethod()
    {
        return $this->controller[1];
    }

    public function isAuthorization(): bool
    {
        return $this->authorization;
    }
}