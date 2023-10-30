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
     * @return void
     */
    public function build(): void
    {
    }
}