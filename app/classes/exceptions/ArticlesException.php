<?php

declare(strict_types=1);

namespace app\classes\exceptions;

use Throwable;

class ArticlesException extends \Exception
{
    public const TITLE_ALREADY_EXISTS = 1;

    public function __construct($message = "", $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}