<?php

declare(strict_types=1);

namespace AMoretti\PhpTest\Database;

interface ConnectionInterface
{
    public function connect(): void;

    public function execute(string $sql);

    public function sanitize(\PDOStatement $statement, array $binds = []);
}
