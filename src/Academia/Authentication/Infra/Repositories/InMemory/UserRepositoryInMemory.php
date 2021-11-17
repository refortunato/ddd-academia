<?php

namespace Academia\Authentication\Infra\Repositories\InMemory;

use Academia\Authentication\Domain\Entities\User;
use Academia\Authentication\Domain\Repositories\UserRepository;

class UserRepositoryInMemory implements UserRepository
{
    private $users = [];

    public function getById(string $id): ?User
    {
        foreach ($this->users as $user) {
            if ($user->getId() == $id) {
                return $user;
            }
        }
        return null;
    }

    public function getByEmail(string $email): ?array
    {
        $users = [];
        foreach ($this->users as $user) {
            if ($user->getEmail() == $email) {
                $users[] = $user;
            }
        }
        return $users;
    }

    public function getAll(): ?Array
    {
        return $this->users;
    }

    public function save(User $user): ?User
    {
        for ($i = 0; $i < count($this->users); $i++) {
            if ($this->users[$i]->getId() == $user->getId()) {
                $this->users[$i] = $user;
                return $user;
            }
        }
        $this->users[] = $user;
        return $user;
    }

    public function delete(string $id): bool
    {
        for ($i = 0; $i < count($this->users); $i++) {
            if ($this->users[$i]->getId() == $id) {
                unset($this->users[$i]);
                $this->users = array_values($this->users);
                return true;
            }
        }
        return false;
    }
}