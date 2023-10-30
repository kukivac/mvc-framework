<?php

namespace system\core\exceptions;

use Exception;
use JetBrains\PhpStorm\Pure;
use Throwable;

class ControllerException extends Exception
{
    /**
     * @param string $message
     * @param int $code
     * @param Throwable|null $previous
     */
    #[Pure] public function __construct(string $message, int $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}