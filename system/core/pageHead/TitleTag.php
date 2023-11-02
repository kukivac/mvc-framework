<?php

namespace system\core\pageHead;

class TitleTag
{
    /** @var string */
    protected $title;

    public function __construct(string $title)
    {
        $this->title = $title;
    }

    public function render(): string
    {
        return "<title>" . $this->title . "</title>";
    }
}