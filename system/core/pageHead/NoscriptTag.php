<?php

namespace system\core\pageHead;

class NoscriptTag
{
    /**
     * NoscriptTag constructor.
     *
     * @param string $noscript
     */
    public function __construct(protected string $noscript)
    {
    }

    public function render(): string
    {
        return "<noscript>".$this->noscript."</noscript>";
    }
}