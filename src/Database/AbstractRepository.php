<?php

declare(strict_types=1);

namespace AMoretti\PhpTest\Database;

class AbstractRepository
{
    protected Connection $connection;

    protected string $table;

    protected array $fields = [];

    protected array $bindNames = [];

    public function __construct()
    {
        $this->connection = new Connection();
    }

    /**
     * Gets an array of data to persis
     * Maps the current array indexes to table columns and creates proper bind variables
     * Executes a call to current Connection object to evaluate the query.
     */
    public function insert(array $data): void
    {
        $this->createFieldsAndBindNamesForQuery($data);
        $sql = "INSERT IGNORE INTO $this->table (".\implode(',', $this->fields).') VALUES ('.\implode(',', $this->bindNames).')';
        $this->connection->execute($sql, $data);
    }

    public function fetchAll(): array
    {
        $sql = "SELECT * FROM $this->table";

        return $this->connection->execute($sql)->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function findBy(array $criteria): array
    {
        $sql = "SELECT * FROM $this->table {$this->createWhereStatement($criteria)}";

        return $this->connection->execute($sql, $criteria)->fetchAll(\PDO::FETCH_ASSOC);
    }

    protected function createWhereStatement(array $criteria): string
    {
        $this->createFieldsAndBindNamesForQuery($criteria);
        $whereStatment = 'WHERE ';
        foreach ($this->fields as $key => $column) {
            $whereStatment .= "$column = {$this->bindNames[$key]}";
        }

        return $whereStatment;
    }

    protected function createFieldsAndBindNamesForQuery(array $data = []): void
    {
        $this->fields = $this->bindNames = [];
        foreach ($data as $property => $value) {
            $this->fields[] = $property;
            $this->bindNames[] = ":$property";
        }
    }

    public function getConnection(): Connection
    {
        return $this->connection;
    }

    public function getTable(): string
    {
        return $this->table;
    }

    /**
     * @return AbstractRepository
     */
    public function setTable(string $table): self
    {
        $this->table = $table;

        return $this;
    }
}
