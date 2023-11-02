<?php

namespace system\core\pageHead;

class MetaTag
{
    /** @var string */
    protected $name;

    /** @var string */
    protected $nameProp;

    /** @var string */
    protected $content;

    /**
     * MetaTag constructor.
     *
     * @param string $name
     * @param string $nameProp
     * @param string $content
     */
    public function __construct(string $name, string $nameProp, string $content)
    {
        $this->content = $content;
        $this->nameProp = $nameProp;
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function render(): string
    {
        return "<meta " . $this->nameProp . "=\"" . $this->name . "\" content=\"" . $this->content . "\">\n";
    }
}