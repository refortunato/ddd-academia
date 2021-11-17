<?php

namespace Academia\Authentication\Infra\Repositories;

use Academia\Authentication\Domain\Entities\User;
use Academia\Authentication\Domain\Repositories\UserRepository;
use Academia\Authentication\Mappers\UserMap;
use Academia\Core\Entity;
use Academia\Core\Infra\DB\DataMapper\Repositories\Repository;

class UserRepositorySql extends Repository implements UserRepository
{
    protected ?string $table = 'users';

    protected function makeEntity(array $fields): ?Entity
    {
        return UserMap::toEntity($fields);
    }

    protected function mapEntityToArrayFields(Entity $user): array
    {
        return UserMap::toPersistance($user);
    }

    public function getById(string $id): ?User
    {
        return $this->first($id);
    }

    public function getByEmail(string $email): ?array
    {
        return $this->getAll([0 => ['email', $email]]);
    }

    public function save(User $user): ?User
    {
        $exists = $this->first($user->getId()) ? true : false;
        if ($exists) {
            $this->update($user);
            return $user;
        }
        $this->insert($user);
        return $user;
    }

    public function getAll(array $condition = []): array
    {
        return $this->all($condition);
    }
}