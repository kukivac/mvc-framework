<?php

namespace system\core\controllers;

use JetBrains\PhpStorm\Pure;
use system\core\AbstractController;

abstract class DataController extends AbstractController
{
    #[Pure] public function __construct(bool $active = true)
    {
        parent::__construct($active);
    }

    /**
     * @param string[] $params
     * @param mixed[]|null $query
     * @return void
     */
    abstract function process(array $params, array $query = null): void;

    /**
     * @param mixed[] $parameters
     * @param mixed[]|null $query
     * @return void
     */
    public function build(array $parameters, array $query = null): void
    {
        $this->process($parameters, $query);
    }
}