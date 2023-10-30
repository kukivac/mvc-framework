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

    abstract function process(array $params, array $query = null);

    public function build(array $parameters, array $query = null)
    {
        $this->process($parameters, $query);
    }
}