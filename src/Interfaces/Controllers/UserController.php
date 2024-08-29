<?php

namespace App\Interfaces\Controllers;

use App\Application\DTOs\CreateUserDTO;
use App\Application\UseCases\CreateUserUseCase;

class UserController
{
    private $createUserUseCase;

    public function __construct(CreateUserUseCase $createUserUseCase)
    {
        $this->createUserUseCase = $createUserUseCase;
    }

    public function create($request)
    {
        $createUserDTO = new CreateUserDTO(
            $request['name'],
            $request['email'],
            $request['password']
        );

        $user = $this->createUserUseCase->execute($createUserDTO);

        return [
            'id' => $user->getId(),
            'name' => $user->getName(),
            'email' => $user->getEmail(),
            'message' => 'Usuario creado exitosamente'
        ];
    }
}