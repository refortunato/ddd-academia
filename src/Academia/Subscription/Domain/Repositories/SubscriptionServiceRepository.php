<?php

namespace Academia\Subscription\Domain\Repositories;

use Academia\Subscription\Domain\Entities\SubscriptionPlan;
use Academia\Subscription\Domain\Entities\SubscriptionService;

interface SubscriptionServiceRepository
{
    public function getById(string $id): ?SubscriptionService;
    public function getAll(): ?Array;
    public function save(SubscriptionService $subscriptionService): ?SubscriptionService;
    public function delete(string $id): bool;
}