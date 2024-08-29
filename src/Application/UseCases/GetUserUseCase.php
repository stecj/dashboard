<?php

namespace App\Application\UseCases;

use App\Domain\Entities\User;
use App\Domain\Repositories\UserRepositoryInterface;
use App\Domain\Exceptions\UserDoesNotExistException;

class GetUserUseCase
{
    private $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function execute(int $userId): User
    {
        return $this->userRepository->getByIdOrFail($userId);
    }
}