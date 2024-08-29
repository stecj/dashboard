<?php

namespace Tests\Domain\Entities;

use PHPUnit\Framework\TestCase;
use App\Domain\Entities\User;

class UserTest extends TestCase
{
    private User $user;
    
    protected function setUp(): void
    {
        $this->user = new User('David', 'david@example.com', 'david123');
    }

    public function testUserCreation()
    {
        $this->assertInstanceOf(User::class, $this->user);
    }

    public function testGetName()
    {
        $this->assertEquals('David', $this->user->getName());
    }

    public function testGetEmail()
    {
        $this->assertEquals('david@example.com', $this->user->getEmail());
    }

    public function testGetPassword()
    {
        $this->assertEquals('david123', $this->user->getPassword());
    }

    public function testSetAndGetId()
    {
        $this->user->setId(1);
        $this->assertEquals(1, $this->user->getId());
    }

    public function testSetName()
    {
        $this->user->setName('David');
        $this->assertEquals('David', $this->user->getName());
    }

    public function testSetEmail()
    {
        $this->user->setEmail('davidtest@example.com');
        $this->assertEquals('davidtest@example.com', $this->user->getEmail());
    }

    public function testSetPassword()
    {
        $this->user->setPassword('newdavid123');
        $this->assertEquals('newdavid123', $this->user->getPassword());
    }
}