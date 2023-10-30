<?php

namespace system\core\controllers;

use Latte\Engine;
use system\core\AbstractController;
use system\core\exceptions\ControllerException;
use system\core\pageHead\PageHead;

abstract class ViewController extends AbstractController
{
    /**
     * @var array $data
     */
    protected array $data = [];

    /**
     * @var string $view
     */
    protected string $view;

    /**
     * @var PageHead $head
     */
    protected PageHead $head;

    /**
     * @var Engine $latte
     * Variable for class Latte\Engine object
     */
    private Engine $latte;

    public function __construct(bool $active = true)
    {
        parent::__construct($active);
        $this->latte = new Engine();
        $this->head = new PageHead();
    }

    abstract function process(array $params, array $query = null);

    /**
     * Renders selected view
     *
     * @return void
     * @throws ControllerException
     */
    public function writeView(): void
    {
        if ($this->view) {
            $this->view = __DIR__ . "/../../../app/views/" . $this->controllerName . "/" . $this->view . ".latte";
            $this->data["head"] = $this->head->render();
            $this->latte->render($this->view, $this->data);
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
     * @throws ControllerException
     */
    public function build(array $parameters, array $query = null)
    {
        $this->process($parameters, $query);
        $this->writeView();
    }
}