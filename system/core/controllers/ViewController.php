<?php

namespace system\core\controllers;

use eftec\bladeone\BladeOne;
use system\core\AbstractController;
use system\core\exceptions\ControllerException;

abstract class ViewController extends AbstractController
{
    /**
     * @var mixed[] $data
     */
    private $data = [];

    /**
     * @var string $view
     */
    protected $view;

    /** @var BladeOne */
    private $view_engine;

    public function __construct(bool $active = true)
    {
        parent::__construct($active);
        $this->view_engine = new BladeOne(
            __DIR__ . "/../../../app/views",
            __DIR__ . "/../../../tmp/cache/compiled_views"
        );
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
            $this->assign("pages",$this->getPages());
            $this->assign("logged_in_user", $this->isLoggedInUser());
            $this->assign("is_admin",$this->isAdmin());
            echo $this->view_engine->run($this->view, $this->data);
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

    private function getPages()
    {
        return [
            ["link" => "/articles", "name" => "Articles"],
            ["link" => "/news", "name" => "News"],
        ];
    }

    /**
     * @param string $key
     * @param mixed $value
     * @return void
     */
    public function assign(string $key, $value)
    {
        $this->data[$key] = $value;
    }
}