<?php

declare(strict_types=1);

namespace AMoretti\PhpTest\Database;

class UserRepository extends AbstractRepository
{
    protected string $table = 'exads_test';

    /**
     * Gets a user entity, maps to the respective field on DB and persist it.
     */
    public function save(UserEntity $entity): void
    {
        $binds = [
            'name' => $entity->getName(),
            'age' => $entity->getAge(),
            'job_title' => $entity->getJobTitle(),
        ];

        $this->insert($binds);
    }
}
