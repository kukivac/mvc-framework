<?php

namespace System\Core\PageHead;

class StyleTag
{
    /**
     * StyleTag constructor.
     *
     * @param string $style
     */
    public function __construct(protected string $style)
    {
    }

    /**
     * @return string
     */
    public function render(): string
    {
        return "<link rel=\"stylesheet\" href=\"" . $this->style . "?v=" . time() . "\" type=\"text/css\">\n";
    }
}