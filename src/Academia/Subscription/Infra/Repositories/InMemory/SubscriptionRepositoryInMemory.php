<?php

namespace Academia\Subscription\Infra\Repositories\InMemory;

use Academia\Subscription\Domain\Entities\Subscription;
use Academia\Subscription\Domain\Repositories\SubscriptionRepository;

class SubscriptionRepositoryInMemory implements SubscriptionRepository
{
    private $subscriptions = [];

    public function getById(string $id): ?Subscription
    {
        foreach ($this->subscriptions as $subscription) {
            if ($subscription->getId() == $id) {
                return $subscription;
            }
        }
        return null;
    }

    public function getAll(): ?Array
    {
        return $this->subscriptions;
    }

    public function getFromCustomer(string $customer_id): ?Array
    {
        $subscriptions = [];
        foreach ($this->subscriptions as $subscription) {
            if ($subscription->getCustomerId() == $customer_id) {
                $subscriptions[] = $subscription;
            }
        }
        return $subscriptions;
    }

    public function save(Subscription $subscription): ?Subscription
    {
        for ($i = 0; $i < count($this->subscriptions); $i++) {
            if ($this->subscriptions[$i]->getId() == $subscription->getId()) {
                $this->subscriptions[$i] = $subscription;
                return $subscription;
            }
        }
        $this->subscriptions[] = $subscription;
        return $subscription;
    }

    public function delete(string $id): bool
    {
        for ($i = 0; $i < count($this->subscriptions); $i++) {
            if ($this->subscriptions[$i]->getId() == $id) {
                unset($this->subscriptions[$i]);
                $this->subscriptions = array_values($this->subscriptions);
                return true;
            }
        }
        return false;
    }
}