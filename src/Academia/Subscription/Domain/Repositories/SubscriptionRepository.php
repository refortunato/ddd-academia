<?php

namespace Academia\Subscription\Domain\Repositories;

use Academia\Subscription\Domain\Entities\Subscription;

interface SubscriptionRepository
{
    public function getById(string $id): ?Subscription;
    public function getAll(): ?Array;
    public function getFromCustomer(string $customer_id): ?Array;
    public function save(Subscription $subscription): ?Subscription;
    public function delete(string $id): bool;
}