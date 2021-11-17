<?php

namespace Academia\Subscription\Infra\Repositories;

use Academia\Subscription\Domain\Entities\SubscriptionPlan;
use Academia\Subscription\Domain\Repositories\SubscriptionPlanRepository;
use Academia\Subscription\Mappers\SubscriptionPlanMap;
use Academia\Core\Entity;
use Academia\Core\Infra\DB\DataMapper\Repositories\Repository;

class SubscriptionPlanRepositorySql extends Repository implements SubscriptionPlanRepository
{
    protected ?string $table = 'subscription_plan';

    protected function makeEntity(array $fields): ?Entity
    {
        return SubscriptionPlanMap::toEntity($fields);
    }

    protected function mapEntityToArrayFields(Entity $subsctiptionPlan): array
    {
        return SubscriptionPlanMap::toPersistance($subsctiptionPlan);
    }

    public function getById(string $id): ?SubscriptionPlan
    {
        return $this->first($id);
    }

    public function save(SubscriptionPlan $subsctiptionPlan): ?SubscriptionPlan
    {
        $exists = $this->first($subsctiptionPlan->getId()) ? true : false;
        if ($exists) {
            $this->update($subsctiptionPlan);
            return $subsctiptionPlan;
        }
        $this->insert($subsctiptionPlan);
        return $subsctiptionPlan;
    }

    public function getAll(array $condition = []): array
    {
        return $this->all($condition);
    }
}