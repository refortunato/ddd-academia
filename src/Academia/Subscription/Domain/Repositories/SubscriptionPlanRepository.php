<?php

namespace Academia\Subscription\Domain\Repositories;

use Academia\Subscription\Domain\Entities\SubscriptionPlan;

interface SubscriptionPlanRepository
{
    public function getById(string $id): ?SubscriptionPlan;
    public function getAll(): ?Array;
    public function save(SubscriptionPlan $subscriptionPlan): ?SubscriptionPlan;
    public function delete(string $id): bool;
}