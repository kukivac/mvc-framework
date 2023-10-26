<?php

namespace System\Core\PageHead;

class TitleTag
{
    public function __construct(protected string $title)
    {
    }

    public function render(): string
    {
        return "<title>" . $this->title . "</title>";
    }
}