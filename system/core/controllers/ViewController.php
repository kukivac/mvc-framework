<?php

namespace system\core\controllers;

use eftec\bladeone\BladeOne;
use Mustache_Engine;
use Mustache_Loader_FilesystemLoader;
use Mustache_Logger_StreamLogger;
use system\core\AbstractController;
use system\core\exceptions\ControllerException;
use system\core\pageHead\PageHead;

abstract class ViewController extends AbstractController
{
    /**
     * @var mixed[] $data
     */
    protected  $data = [];

    /**
     * @var string $view
     */
    protected  $view;

    /**
     * @var PageHead $head
     */
    protected  $head;

    /** @var BladeOne */
    private  $view_engine;

    public function __construct(bool $active = true)
    {
        parent::__construct($active);
        $this->view_engine = new BladeOne(
            __DIR__ . "/../../../app/views",
            __DIR__ . "/../../../tmp/cache/compiled_views"
        );
        $this->head = new PageHead();
    }

    /**
     * Renders selected view
     *
     * @return void
     * @throws ControllerException
     */
    public function writeView(): void
    {
        if ($this->view) {
            $this->data["head"] = $this->head->render();
            echo $this->view_engine->run($this->view,$this->data);
        } else {
            throw new ControllerException("View file not selected");
        }
    }

    /**
     * Sets value of view
     *
     * @param string $view
     * View name
     *
     * @return void
     */
    public function setView(string $view): void
    {
        $this->view = $view;
    }

    /**
     * @return string|null
     */
    public function getView(): ?string
    {
        return $this->view;
    }

    /**
     * @return void
     * @throws ControllerException
     */
    public function build(): void
    {
        $this->writeView();
    }
}