<?php

namespace Academia\Subscription\Infra\Repositories;

use Academia\Subscription\Domain\Entities\Service;
use Academia\Subscription\Domain\Repositories\ServiceRepository;
use Academia\Subscription\Mappers\ServiceMap;
use Academia\Core\Entity;
use Academia\Core\Infra\DB\DataMapper\Repositories\Repository;

class ServiceRepositorySql extends Repository implements ServiceRepository
{
    protected ?string $table = 'service';

    protected function makeEntity(array $fields): ?Entity
    {
        return ServiceMap::toEntity($fields);
    }

    protected function mapEntityToArrayFields(Entity $service): array
    {
        return ServiceMap::toPersistance($service);
    }

    public function getById(string $id): ?Service
    {
        return $this->first($id);
    }

    public function save(Service $service): ?Service
    {
        $exists = $this->first($service->getId()) ? true : false;
        if ($exists) {
            $this->update($service);
            return $service;
        }
        $this->insert($service);
        return $service;
    }

    public function getAll(array $condition = []): array
    {
        return $this->all($condition);
    }
}