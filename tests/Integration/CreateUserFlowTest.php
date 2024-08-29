<?php

namespace Tests\Integration;

use PHPUnit\Framework\TestCase;
use App\Interfaces\Controllers\UserController;
use App\Application\UseCases\CreateUserUseCase;
use App\Infrastructure\Repositories\UserRepository;
use App\Infrastructure\Persistence\DatabaseConnection;

class CreateUserFlowTest extends TestCase
{
    private $pdo;
    private $userController;

    protected function setUp(): void
    {
        $this->pdo = new \PDO('sqlite::memory:');
        $this->pdo->exec('CREATE TABLE users (id INTEGER PRIMARY KEY, name TEXT, email TEXT, password TEXT)');

        $userRepository = new UserRepository($this->pdo);
        $createUserUseCase = new CreateUserUseCase($userRepository);
        $this->userController = new UserController($createUserUseCase);
    }

    public function testCreateUserFlow()
    {
        $request = [
            'name' => 'David',
            'email' => 'david@example.com',
            'password' => 'david123'
        ];

        $response = $this->userController->create($request);

        $this->assertArrayHasKey('id', $response);
        $this->assertEquals('David', $response['name']);
        $this->assertEquals('david@example.com', $response['email']);

        // Verificar que el usuario se guardó en la base de datos
        $query = $this->pdo->prepare("SELECT * FROM users WHERE email = ?");
        $query->execute(['david@example.com']);
        $user = $query->fetch(\PDO::FETCH_ASSOC);

        $this->assertNotFalse($user);
        $this->assertEquals('David', $user['name']);
    }

    protected function tearDown(): void
    {
        $this->pdo->exec('DROP TABLE users');
    }
}