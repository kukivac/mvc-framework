<?php

namespace system\core\pageHead;

class NoscriptTag
{/** @var string  */
    protected $noscript;

    /**
     * NoscriptTag constructor.
     *
     * @param string $noscript
     */
    public function __construct(string $noscript)
    {
        $this->noscript = $noscript;
    }

    public function render(): string
    {
        return "<noscript>" . $this->noscript . "</noscript>";
    }
}