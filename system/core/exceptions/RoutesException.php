<?php

namespace System\Core\Exceptions;

use Exception;
use JetBrains\PhpStorm\Pure;
use Throwable;

class RoutesException extends Exception
{
    #[Pure] public function __construct($message, $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}