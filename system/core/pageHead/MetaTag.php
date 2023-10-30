<?php

namespace system\core\pageHead;

class MetaTag
{
    /**
     * MetaTag constructor.
     *
     * @param string $name
     * @param string $nameProp
     * @param string $content
     */
    public function __construct(protected string $name, protected string $nameProp, protected string $content)
    {
    }

    /**
     * @return string
     */
    public function render(): string
    {
        return "<meta " . $this->nameProp . "=\"" . $this->name . "\" content=\"" . $this->content . "\">\n";
    }
}