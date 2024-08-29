<?php

namespace Tests\Application\UseCases;

use PHPUnit\Framework\TestCase;
use App\Application\UseCases\CreateUserUseCase;
use App\Application\DTOs\CreateUserDTO;
use App\Domain\Entities\User;
use App\Domain\Repositories\UserRepositoryInterface;

class CreateUserUseCaseTest extends TestCase
{
    // Se crea un mock y se valida instancia, además de propiedades
    public function testExecute()
    {
        $mockRepository = $this->createMock(UserRepositoryInterface::class);
        $mockRepository->expects($this->once())
            ->method('save')
            ->willReturnCallback(function(User $user) {
                $user->setId(1);
                return $user;
            });

        $useCase = new CreateUserUseCase($mockRepository);

        $dto = new CreateUserDTO('David', 'david@example.com', 'david123');

        $result = $useCase->execute($dto);

        $this->assertInstanceOf(User::class, $result);
        $this->assertEquals(1, $result->getId());
        $this->assertEquals('David', $result->getName());
        $this->assertEquals('david@example.com', $result->getEmail());
    }
}