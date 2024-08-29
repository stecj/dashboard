<?php

namespace Tests\Application\UseCases;

use PHPUnit\Framework\TestCase;
use App\Application\UseCases\GetUserUseCase;
use App\Domain\Repositories\UserRepositoryInterface;
use App\Domain\Exceptions\UserDoesNotExistException;

class GetUserUseCaseTest extends TestCase
{
    //Excepción personalizada a partir de un mock, y enviando un ID inexistente
    public function testWhenUserIsNotFoundByIdErrorIsThrown(): void
    {
        $mockRepository = $this->createMock(UserRepositoryInterface::class);

        $mockRepository->method('getByIdOrFail')
            ->willThrowException(new UserDoesNotExistException());

        $useCase = new GetUserUseCase($mockRepository);

        $this->expectException(UserDoesNotExistException::class);

        $useCase->execute(999);
    }
}