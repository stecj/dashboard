<?php

namespace App\Infrastructure\Repositories;

use App\Domain\Entities\User;
use App\Domain\Repositories\UserRepositoryInterface;
use App\Domain\Exceptions\UserDoesNotExistException;
use PDO;

class UserRepository implements UserRepositoryInterface
{
    private PDO $db;

    public function __construct(PDO $db)
    {
        $this->db = $db;
    }

    public function save(User $user)
    {
        $stmt = $this->db->prepare("INSERT INTO users (name, email, password) VALUES (?, ?, ?)");
        $stmt->execute([$user->getName(), $user->getEmail(), $user->getPassword()]);
        $user->setId($this->db->lastInsertId());
    }

    public function update(User $user)
    {
        $stmt = $this->db->prepare("UPDATE users SET name = ?, email = ?, password = ? WHERE id = ?");
        $stmt->execute([$user->getName(), $user->getEmail(), $user->getPassword(), $user->getId()]);
    }

    public function delete(User $user)
    {
        $stmt = $this->db->prepare("DELETE FROM users WHERE id = ?");
        $stmt->execute([$user->getId()]);
    }

    public function findById(int $id): ?User
    {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE id = ?");
        $stmt->execute([$id]);
        $userData = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$userData) {
            return null;
        }

        $user = new User($userData['name'], $userData['email'], $userData['password']);
        $user->setId($userData['id']);
        return $user;
    }

    public function getByIdOrFail(int $id): User
    {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE id = ?");
        $stmt->execute([$id]);
        $userData = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$userData) {
            throw new UserDoesNotExistException("User with id $id does not exist");
        }

        $user = new User($userData['name'], $userData['email'], $userData['password']);
        $user->setId($userData['id']);
        return $user;
    }
}