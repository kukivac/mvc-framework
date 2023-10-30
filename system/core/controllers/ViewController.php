<?php

namespace system\core\controllers;

use Latte\Engine;
use system\core\AbstractController;
use system\core\exceptions\ControllerException;
use system\core\pageHead\PageHead;

abstract class ViewController extends AbstractController
{
    /**
     * @var mixed[] $data
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

    /**
     * @param string[] $params
     * @param mixed[]|null $query
     * @return void
     */
    abstract function process(array $params, array $query = null): void;

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
     * @param string[] $parameters
     * @param mixed[]|null $query
     * @return void
     * @throws ControllerException
     */
    public function build(array $parameters, array $query = null): void
    {
        $this->process($parameters, $query);
        $this->writeView();
    }
}