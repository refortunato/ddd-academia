<?php

namespace Academia\Authentication\Domain\Repositories;

use Academia\Authentication\Domain\Entities\User;

interface UserRepository
{
    public function getById(string $id): ?User;
    public function getByEmail(string $email): ?array;
    public function getAll(): ?Array;
    public function save(User $user): ?User;
    public function delete(string $id): bool;
}