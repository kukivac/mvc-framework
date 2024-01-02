<?php

namespace system\core\controllers;

use system\core\AbstractController;
use system\core\api\ApiResponse;

abstract class DataController extends AbstractController
{
    /** @var ApiResponse|null */
    private $response = null;

    public function __construct(bool $active = true)
    {
        parent::__construct($active);
    }

    /**
     * @return void
     */
    public function build(): void
    {
        $this->response->render();
    }

    public function setResponse(?ApiResponse $response): void
    {
        $this->response = $response;
    }
}