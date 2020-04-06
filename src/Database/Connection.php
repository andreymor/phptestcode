<?php

declare(strict_types=1);

namespace AMoretti\PhpTest\Database;

class Connection implements ConnectionInterface
{
    protected \PDO $handler;
    protected string $host;
    protected string $dbname;
    protected string $user;
    protected string $pass;
    protected string $port = '3306';

    public function __construct(?string $host = null, ?string $dbname = null, ?string $user = null, ?string $pass = null, ?string $port = '3306')
    {
        $this->host = $host ?? \getenv('DB_HOST');
        $this->dbname = $dbname ?? \getenv('DB_NAME');
        $this->user = $user ?? \getenv('DB_USER');
        $this->pass = $pass ?? \getenv('DB_PASSWORD');
        $this->port = $port ?? \getenv('DB_PORT');

        $this->connect();
    }

    /**
     * Prepares the connection using parameters from ENV Variables
     * Throws a ConnectionException in case of failure.
     */
    public function connect(): void
    {
        try {
            $this->handler = new \PDO("mysql:host=mysql;port=$this->port;dbname=$this->dbname", $this->user, $this->pass);
            $this->handler->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
            $this->handler->setAttribute(\PDO::ATTR_EMULATE_PREPARES, false);
        } catch (\PDOException $e) {
            throw new ConnectionException($e->getMessage(), $e->getCode(), $e);
        }
    }

    /**
     * Prepare, sanitize and execute a SQL statement.
     */
    public function execute(string $sql, array $binds = [])
    {
        try {
            $statement = $this->handler->prepare($sql);
            $this->sanitize($statement, $binds);
            $statement->execute();

            return $statement;
        } catch (\PDOException $e) {
            throw new DBException($e->getMessage(), 500, $e);
        }
    }

    /**
     * Sanitizes the content to be inserted into DB to avoid SQL Injectio.
     */
    public function sanitize(\PDOStatement $statement, array $binds = []): void
    {
        foreach ($binds as $key => &$value) {
            $statement->bindParam(":$key", $value, $this->getTypeOfFromPDO($value));
        }
    }

    /**
     * Matches the current input valye type with default constants on PDO.
     */
    protected function getTypeOfFromPDO($value): int
    {
        $fromPDOConstants = [
            'string' => \PDO::PARAM_STR,
            'integer' => \PDO::PARAM_INT,
            'boolean' => \PDO::PARAM_BOOL,
        ];

        return $fromPDOConstants[\gettype($value)];
    }
}
