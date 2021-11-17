<?php

namespace Academia\Subscription\Infra\Repositories;

use Academia\Core\Entity;
use Academia\Core\Infra\DB\DataMapper\Repositories\Repository;
use Academia\Subscription\Domain\Entities\SubscriptionService;
use Academia\Subscription\Domain\Repositories\SubscriptionServiceRepository;
use Academia\Subscription\Mappers\SubscriptionServiceMap;

class SubscriptionServiceRepositorySql extends Repository implements SubscriptionServiceRepository
{
    protected ?string $table = 'subscription_services';

    protected function makeEntity(array $fields): ?Entity
    {
        return SubscriptionServiceMap::toEntity($fields);
    }

    protected function mapEntityToArrayFields(Entity $customer): array
    {
        return SubscriptionServiceMap::toPersistance($customer);
    }

    public function getById(string $id): ?SubscriptionService
    {
        return $this->first($id);
    }

    public function save(SubscriptionService $service): ?SubscriptionService
    {
        $exists = $this->first($service->getId()) ? true : false;
        if ($exists) {
            $this->update($service);
            return $service;
        }
        $this->insert($service);
        return $service;
    }

    public function getAll(array $condition = []): ?array
    {
        return $this->all($condition);
    }
}