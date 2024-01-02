<?php

namespace app\config;

use PDO;
use system\core\routes\Router;

/**
 * Config DbConfig
 *
 * @package app\config
 */
class DbConfig
{
    /** @var string */
    private static $host = '127.0.0.1';

    /** @var string */
    private static $username = 'username';

    /** @var string */
    private static $pass = 'password';

    /** @var string */
    private static $kraken_pass = 'kraken_password';

    /** @var string */
    private static $database = 'database_name';

    /**
     * @var mixed[]
     */
    private static $settings = [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8",
        PDO::ATTR_EMULATE_PREPARES => false,
    ];

    public static function getHost(): string
    {
        return self::$host;
    }

    public static function getUsername(): string
    {
        return self::$username;
    }

    public static function getPass(): string
    {
        if (Router::isKraken()) {
            return self::$kraken_pass;
        } else {
            return self::$pass;
        }
    }

    public static function getDatabase(): string
    {
        return self::$database;
    }

    /**
     * @return mixed[]
     */
    public static function getSettings(): array
    {
        return self::$settings;
    }
}