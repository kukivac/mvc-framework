<?php

namespace system\core\pageHead;

class StyleTag
{
    /** @var string */
    protected $style;

    /**
     * StyleTag constructor.
     *
     * @param string $style
     */
    public function __construct(string $style)
    {
        $this->style = $style;
    }

    /**
     * @return string
     */
    public function render(): string
    {
        return "<link rel=\"stylesheet\" href=\"" . $this->style . "?v=" . time() . "\" type=\"text/css\">\n";
    }
}