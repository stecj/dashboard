<?php

namespace Tests\Infrastructure\Repositories;

use PHPUnit\Framework\TestCase;
use App\Infrastructure\Repositories\UserRepository;
use App\Domain\Exceptions\UserDoesNotExistException;
use App\Infrastructure\Persistence\DatabaseConnection;

class UserRepositoryIntegrationTest extends TestCase
{
    private $pdo;
    private $repository;

    protected function setUp(): void
    {
        $this->pdo = new \PDO('sqlite::memory:');
        $this->pdo->exec('CREATE TABLE users (id INTEGER PRIMARY KEY, name TEXT, email TEXT, password TEXT)');

        $this->repository = new UserRepository($this->pdo);
    }

    public function testWhenUserIsNotFoundByIdErrorIsThrown(): void
    {
        $this->expectException(UserDoesNotExistException::class);
        $this->repository->getByIdOrFail(999);
    }

    protected function tearDown(): void
    {
        $this->pdo->exec('DROP TABLE users');
    }
}