<?php

namespace app\config;

use PDO;
use system\core\Routes\Router;

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
    private static $username = 'kovacjaku';

    /** @var string */
    private static $pass = 'xHeslo123';

    /** @var string */
    private static $kraken_pass = 'KraKEN-9.3.2001';

    /** @var string */
    private static $database = 'kovacjaku';

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