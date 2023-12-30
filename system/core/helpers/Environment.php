<?php

declare(strict_types=1);

namespace system\core\helpers;

class Environment
{
    public const DEVELOPMENT = "dev";
    public const PRODUCTION = "prod";

    /** @var string|null */
    private static $system_environment = null;

    /** @var bool */
    private static $use_database = null;

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

    /**
     * @param bool $use_database
     * @return void
     */
    public static function setUseDatabase(bool $use_database): void
    {
        if (self::$use_database === null) {
            self::$use_database = $use_database;
        } else {
            throw new \RuntimeException("Database usage flag already set!");
        }
    }

    public static function useDatabase()
    {
        return self::$use_database;
    }
}