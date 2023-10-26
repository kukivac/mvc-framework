<?php

declare(strict_types=1);

namespace System\Core\Helpers;

class Enviroment
{
    const DEV_ENVIROMENT = "dev";
    const ENV = self::DEV_ENVIROMENT;

    /**
     * @return string
     */
    public static function getSystemEnviroment(): string
    {
        return self::ENV;
    }
}