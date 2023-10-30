<?php

namespace system\database;

use app\config\DbConfig as Credentials;
use JetBrains\PhpStorm\Pure;
use PDO;
use PDOStatement;
use system\core\exceptions\DatabaseException;

class Database
{
    /** @var PDO */
    private PDO $pdo;

    /** @var mixed[] */
    private array $parameters;

    /** @var string */
    private string $query;

    /** @var PDOStatement */
    public PDOStatement $statement;

    /** @var bool */
    private bool $transactionBegan;

    /** @var bool */
    private bool $executed;

    /**
     * Database constructor.
     */
    public function __construct()
    {
        $database_credentials = Credentials::returnConfig();
        $dsn = "mysql:host=" . $database_credentials["host"] . ";dbname=" . $database_credentials["database"];
        $this->pdo = new PDO($dsn, $database_credentials["username"], $database_credentials["password"], $database_credentials["options"]);
        $this->parameters = [];
        $this->transactionBegan = false;
        $this->executed = false;
    }

    /**
     * @param string $sql
     * @param mixed ...$parameters
     *
     * @return void
     * @throws DatabaseException
     */
    public function prepare(string $sql, ...$parameters): void
    {
        if (!empty($parameters)) {
            $this->setParameters($parameters);
        }
        $this->setQuery($sql);
        $this->prepareStatement($this->pdo->prepare($this->query));
    }

    /**
     * @param mixed ...$parameters
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
        $executed = $this->statement->execute($this->parameters);
        $this->setExecuted();

        return $executed;
    }

    /**
     * @param mixed ...$parameters
     *
     * @return mixed
     * @throws DatabaseException
     */
    public function fetchRow(...$parameters): mixed
    {
        if (!empty($parameters)) {
            $this->setParameters($parameters);
        }
        if ($this->statementExecuted()) {
            $this->execute();
        }

        return $this->statement->fetch();
    }

    /**
     * @param mixed ...$parameters
     *
     * @return mixed[]
     * @throws DatabaseException
     */
    public function fetchRows(...$parameters): array
    {
        if (!empty($parameters)) {
            $this->setParameters($parameters);
        }
        if ($this->statementExecuted()) {
            $this->execute();
        }

        return $this->statement->fetchAll();
    }

    /**
     * @param mixed ...$parameters
     *
     * @return mixed
     * @throws DatabaseException
     */
    public function fetchCell(...$parameters): mixed
    {
        $this->setFetchMode(PDO::FETCH_NUM);

        return ($this->fetchRow(...$parameters)[0]);
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
     * @param mixed[] $parameters
     *
     * @return void
     */
    private function setParameters(array $parameters): void
    {
        $this->parameters = $parameters;
    }

    /**
     * @param int $fetchMode
     * @param mixed ...$parameters
     *
     * @return void
     * @throws DatabaseException
     */
    public function setFetchMode(int $fetchMode, ...$parameters): void
    {
        if (!$this->statementPrepared()) {
            throw new DatabaseException("Cannot set fetch mode before statement is prepared");
        }
        $this->statement->setFetchMode($fetchMode, ...$parameters);
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

    /**
     * @return string|false
     */
    public function lastInsertId(): string|false
    {
        return $this->pdo->lastInsertId();
    }
}