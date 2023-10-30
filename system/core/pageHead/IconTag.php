<?php

namespace system\core\pageHead;

class IconTag
{
    /**
     * IconTag constructor.
     *
     * @param string $rel
     * @param string|null $type
     * @param string $href
     */
    public function __construct(protected string $rel, protected ?string $type, protected string $href)
    {
    }

    /**
     * @return string
     */
    public function render(): string
    {
        return "<link rel=\"" . $this->rel . "\" type=\"" . $this->type . "\" href=\"" . $this->href . "\">\n";
    }
}