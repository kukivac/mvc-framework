<?php

declare(strict_types=1);

namespace System\Core\Helpers;

class Environment
{
    const DEV_ENVIROMENT = "dev";
    const DEV_PRODUCTION = "prod";

    /** @var string|null */
    private static ?string $system_environment = null;

    /**
     * @return string
     */
    public static function getSystemEnvironment(): string
    {
        if (self::$system_environment === null) {
            throw new \RuntimeException("No environment is set!");
        } else {
            return self::$system_environment;
        }
    }

    /**
     * @param string $system_environment
     * @return void
     */
    public static function setSystemEnvironment(string $system_environment): void
    {
        if (self::$system_environment === null) {
            self::$system_environment = $system_environment;
        } else {
            throw new \RuntimeException("System environment already set!");
        }
    }
}