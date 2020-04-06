<?php

declare(strict_types=1);

namespace AMoretti\PhpTest\Tests\Database;

use AMoretti\PhpTest\Database\UserEntity;
use AMoretti\PhpTest\Database\UserRepository;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 */
class UserRepositoryTest extends TestCase
{
    protected UserRepository $repository;

    public function setUp(): void
    {
        $tmpTableSql = <<<SQL
            CREATE TABLE exads_test_test (
                id INT AUTO_INCREMENT NOT NULL,
                name VARCHAR(255) NOT NULL,
                age INT NOT NULL,
                job_title VARCHAR(255) NOT NULL,
                PRIMARY KEY(id)
            ) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB;
        SQL;

        $this->repository = new UserRepository();
        $this->repository->getConnection()->execute($tmpTableSql);

        parent::setUp();
    }

    /**
     * @group database
     */
    public function testDataIsPersisted(): void
    {
        $user = (new UserEntity())->setName('Test')->setAge(30)->setJobTitle('Tester');
        $this->repository->setTable('exads_test_test')->save($user);

        $userOnDb = $this->repository->getConnection()->execute('SELECT id, name, age, job_title FROM exads_test_test')->fetchAll();

        $this->assertNotEmpty($userOnDb[0]['id']);
        $this->assertEquals($userOnDb[0]['name'], 'Test');
        $this->assertEquals($userOnDb[0]['age'], 30);
        $this->assertEquals($userOnDb[0]['job_title'], 'Tester');
    }

    public function tearDown(): void
    {
        $this->repository->getConnection()->execute('DROP TABLE exads_test_test');
        parent::tearDown();
    }
}
