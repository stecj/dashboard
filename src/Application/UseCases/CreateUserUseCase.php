<?php

namespace App\Application\UseCases;

use App\Application\DTOs\CreateUserDTO;
use App\Domain\Entities\User;
use App\Domain\Repositories\UserRepositoryInterface;

class CreateUserUseCase
{
    private $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function execute(CreateUserDTO $dto): User
    {
        $user = new User($dto->name, $dto->email, $dto->password);
        $this->userRepository->save($user);
        return $user;
    }
}