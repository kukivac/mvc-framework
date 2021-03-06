<?php

namespace system\database;

use app\config\DbConfig as Credentials;
use JetBrains\PhpStorm\Pure;
use PDO;
use PDOStatement;
use system\core\exceptions\DatabaseException;

class Database
{
    private PDO $pdo;
    private array $params;
    private string $query;
    public PDOStatement $statement;
    private bool $transactionBegan;
    private bool $executed;

    /**
     * Database constructor.
     */
    public function __construct()
    {
        /**
         * @var string $host
         * @var string $username
         * @var string $password
         * @var string $database
         * @var array  $options
         */
        extract(Credentials::returnConfig());
        $dsn = "mysql:host=$host;dbname=$database";
        $this->pdo = new PDO($dsn, $username, $password, $options);
        $this->params=[];
        $this->transactionBegan = false;
        $this->executed = false;
    }

    /**
     * @param $sql
     * @param ...$parameters
     *
     * @return void
     * @throws DatabaseException
     */
    public function prepare($sql, ...$parameters): void
    {
        if (!empty($parameters)) {
            $this->setParameters($parameters);
        }
        $this->setQuery($sql);
        $this->prepareStatement($this->pdo->prepare($this->query));
    }


    /**
     * @param ...$parameters
     *
     * @return bool
     * @throws DatabaseException
     */
    public function execute(...$parameters): bool
    {
        if (!empty($parameters)) {
            $this->setParameters($parameters);
        }
        if (!$this->executable()) {
            throw new DatabaseException("Execute cannot be called before statement is prepared");
        }
        $executed = $this->statement->execute($this->params);
        $this->setExecuted();
        return $executed;
    }

    /**
     * @param mixed ...$params
     *
     * @return mixed
     * @throws DatabaseException
     */
    public function fetchRow(...$params): mixed
    {
        if (!empty($params)) {
            $this->setParameters($params);
        }
        if ($this->statementExecuted()) {
            $this->execute();
        }
        return $this->statement->fetch();
    }

    /**
     * @param mixed ...$params
     *
     * @return array
     * @throws DatabaseException
     */
    public function fetchRows(...$params): array
    {
        if (!empty($params)) {
            $this->setParameters($params);
        }
        if ($this->statementExecuted()) {
            $this->execute();
        }
        return $this->statement->fetchAll();
    }

    /**
     * @param mixed ...$params
     *
     * @return mixed
     * @throws DatabaseException
     */
    public function fetchCell(...$params): mixed
    {
        $this->setFetchMode(PDO::FETCH_NUM);
        return ($this->fetchRow(...$params)[0]);
    }


    /**
     * @param string $query
     *
     * @return void
     */
    private function setQuery(string $query): void
    {
        $this->query = $query;
    }

    /**
     * @param array $params
     *
     * @return void
     */
    private function setParameters(array $params): void
    {
        $this->params = $params;
    }

    /**
     * @param int   $fetchMode
     * @param mixed ...$params
     *
     * @return void
     * @throws DatabaseException
     */
    public function setFetchMode(int $fetchMode, ...$params): void
    {
        if (!$this->statementPrepared()) {
            throw new DatabaseException("Cannot set fetch mode before statement is prepared");
        }
        $this->statement->setFetchMode($fetchMode, ...$params);
    }

    /**
     * @return void
     */
    private function setExecuted(): void
    {
        $this->executed = true;
    }

    /**
     * @param mixed $statement
     *
     * @return void
     * @throws DatabaseException
     */
    private function prepareStatement(mixed $statement): void
    {
        if (!is_a($statement, "PDOStatement")) {
            throw new DatabaseException("Unable to prepare statement");
        }
        $this->statement = $statement;
    }

    /**
     * @return void
     * @throws DatabaseException
     */
    public function beginTransaction(): void
    {
        if ($this->transactionBegan) {
            throw new DatabaseException("Transaction allready began");
        }
        $this->pdo->beginTransaction();
        $this->transactionBegan = true;
    }

    /**
     * @return void
     * @throws DatabaseException
     */
    public function commit(): void
    {
        if (!$this->transactionBegan) {
            throw new DatabaseException("No transaction began");
        }
        $this->pdo->commit();
        $this->transactionBegan = false;
    }

    /**
     * @return void
     * @throws DatabaseException
     */
    public function rollback(): void
    {
        if (!$this->transactionBegan) {
            throw new DatabaseException("No transaction began");
        }
        $this->pdo->rollBack();
        $this->transactionBegan = false;
    }

    /**
     * @return bool
     */
    #[Pure] private function executable(): bool
    {
        return $this->statementPrepared();
    }

    /**
     * @return bool
     */
    private function statementPrepared(): bool
    {
        return isset($this->statement);
    }

    /**
     * @return bool
     */
    private function statementExecuted(): bool
    {
        return !$this->executed;
    }

    public function lastInsertId(): string
    {
        return $this->pdo->lastInsertId();
    }
}