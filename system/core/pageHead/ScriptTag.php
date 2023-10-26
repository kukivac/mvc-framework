<?php

namespace System\Core\PageHead;

class ScriptTag
{
    const ASYNC = "async";
    const DEFER = "defer";

    /**
     * ScriptTag constructor.
     *
     * @param string $script
     * @param string $async
     */
    public function __construct(protected string $script, protected string $async)
    {
    }

    /**
     * @return string
     */
    public function render(): string
    {
        return "<script src=\"" . $this->script . "?v=" . time() . "\" " . $this->async . "></script>\n";
    }
}