<?php

namespace app\config;

use JetBrains\PhpStorm\ArrayShape;
use PDO;

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

    private static $username = 'root';

    /** @var string */

    private static $pass = '';

    /** @var string */

    private static $database = 'mydb';

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
        return self::$pass;
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