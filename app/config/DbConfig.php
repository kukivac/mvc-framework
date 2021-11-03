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
    private static string $host = '127.0.0.1';
    private static string $username = 'root';
    private static string $pass = '';
    private static string $database = 'mydb';
    private static array $settings = [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8",
        PDO::ATTR_EMULATE_PREPARES => false,
    ];

    /**
     * @return array
     */
    #[ArrayShape(["host" => "string", "username" => "string", "password" => "string", "database" => "string", "options" => "array"])] public static function returnConfig():array
    {
        return array(
            "host" => DbConfig::$host,
            "username" => DbConfig::$username,
            "password" => DbConfig::$pass,
            "database" => DbConfig::$database,
            "options" => DbConfig::$settings
        );
    }
}