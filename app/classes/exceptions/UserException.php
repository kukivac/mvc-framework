<?php

declare(strict_types=1);

namespace app\classes\exceptions;

use Throwable;

class UserException extends \Exception
{
    public const USER_NOT_FOUND = 1;
    public const PASSWORD_NOT_MATCH = 2;
    public const USER_ALREADY_EXISTS = 3;

    public function __construct($message = "", $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}