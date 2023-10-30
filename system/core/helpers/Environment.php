<?php

declare(strict_types=1);

namespace System\Core\Helpers;

class Environment
{
    /** @var SystemEnvironments|null */
    private static ?SystemEnvironments $system_environment = null;

    /**
     * @return SystemEnvironments
     */
    public static function getSystemEnvironment(): SystemEnvironments
    {
        if (self::$system_environment === null) {
            throw new \RuntimeException("No environment is set!");
        } else {
            return self::$system_environment;
        }
    }

    /**
     * @param SystemEnvironments $system_environment
     * @return void
     */
    public static function setSystemEnvironment(SystemEnvironments $system_environment): void
    {
        if (self::$system_environment === null) {
            self::$system_environment = $system_environment;
        } else {
            throw new \RuntimeException("System environment already set!");
        }
    }
}