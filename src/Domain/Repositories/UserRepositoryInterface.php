<?php

namespace App\Domain\Repositories;

use App\Domain\Entities\User;

interface UserRepositoryInterface
{
    public function save(User $user);
    public function update(User $user);
    public function delete(User $user);
    public function findById(int $id): ?User;
    public function getByIdOrFail(int $id): User;
}