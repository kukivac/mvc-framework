<?php

declare(strict_types=1);

namespace system\core\model;

use app\config\DbConfig as Credentials;
use Dibi\Connection;
use Dibi\Exception;

class Model
{
    /** @var Connection */
    private $database_connection;

    /** @var string */
    private $table_name = "";

    public function __construct()
    {
        $this->database_connection = new Connection([
            'driver' => 'mysqli',
            'host' => Credentials::getHost(),
            'username' => Credentials::getUsername(),
            'password' => Credentials::getPass(),
            'database' => Credentials::getDatabase(),
            'charset'  => 'utf8',
        ]);
    }

    /**
     * @return Connection
     */
    public function getDatabaseConnection(): Connection
    {
        return $this->database_connection;
    }

    /**
     * @param Connection $database_connection
     * @return void
     */
    public function setDatabaseConnection(Connection $database_connection): void
    {
        $this->database_connection = $database_connection;
    }
}