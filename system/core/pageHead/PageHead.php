<?php

namespace system\core\pageHead;

class PageHead
{
    /** @var MetaTag[] */
    private array $metas;

    /** @var IconTag[] */
    private array $icons;

    /** @var ScriptTag[] */
    private array $scripts;

    private TitleTag $title;

    private NoscriptTag $noscript;

    /** @var StyleTag[] */
    private array $styles;

    /** @var string */
    public string $resultHead;

    public function __construct()
    {
        $this->metas = [];
        $this->icons = [];
        $this->scripts = [];
        $this->styles = [];
        $this->resultHead = "";
    }

    /**
     * Adds meta tags to the page head
     *
     * @param string $name Meta property name
     * @param string $content Meta property content
     * @param string $nameProp Optional meta property, default "name"
     *
     * @return void
     */
    public function addMeta(string $name, string $content, string $nameProp = "name"): void
    {
        $this->metas [] = new MetaTag($name, $nameProp, $content);
    }

    /**
     * Adds icons to the page head
     *
     * @param string $rel Icon relation type
     * @param string $href Icon link
     * @param string|null $type Icon type
     */
    public function addIcon(string $rel, string $href, string $type = null): void
    {
        $this->icons [] = new IconTag($rel, $type, $href);
    }

    /**
     * Adds title to page head
     *
     * @param string $title Page title
     */
    public function addTitle(string $title): void
    {
        $this->title = new TitleTag($title);
    }

    /**
     * Adds script to page head
     *
     * @param string $script Scripts link
     * @param string $async Async or defer attribute
     */
    public function addScript(string $script, string $async = ""): void
    {
        $this->scripts[] = new ScriptTag($script, $async);
    }

    /**
     * Adds noscript message to page
     *
     * @param string $noscriptText Noscript text
     */
    public function addNoscript(string $noscriptText): void
    {
        $this->noscript = new NoscriptTag($noscriptText);
    }

    /**
     * Add stylesheets to page
     *
     * @param string $style Stylesheet link
     */
    public function addStyle(string $style): void
    {
        $this->styles[] = new StyleTag($style);
    }

    /**
     * Returns rendered page head with all the defined elements
     *
     * @return string
     */
    public function render(): string
    {
        foreach ($this->metas as $meta) {
            $this->resultHead .= $meta->render();
        }
        if (!isset($this->title)) {
            $this->addTitle("Page");
        }
        $this->resultHead .= $this->title->render();
        foreach ($this->icons as $icon) {
            $this->resultHead .= $icon->render();
        }
        foreach ($this->scripts as $script) {
            $this->resultHead .= $script->render();
        }
        foreach ($this->styles as $style) {
            $this->resultHead .= $style->render();
        }
        if (isset($this->noscript)) {
            $this->resultHead .= $this->noscript->render();
        }

        return $this->resultHead;
    }
}