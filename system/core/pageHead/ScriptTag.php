<?php

namespace system\core\pageHead;

class ScriptTag
{
    const ASYNC = "async";
    const DEFER = "defer";

    /** @var string */
    protected $script;

    /** @var string */
    protected $async;

    /**
     * ScriptTag constructor.
     *
     * @param string $script
     * @param string $async
     */
    public function __construct(string $script, string $async)
    {
        $this->async = $async;
        $this->script = $script;
    }

    /**
     * @return string
     */
    public function render(): string
    {
        return "<script src=\"" . $this->script . "?v=" . time() . "\" " . $this->async . "></script>\n";
    }
}