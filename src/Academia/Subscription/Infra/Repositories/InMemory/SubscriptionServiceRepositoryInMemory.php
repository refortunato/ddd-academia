<?php

namespace Academia\Subscription\Infra\Repositories\InMemory;

use Academia\Subscription\Domain\Entities\SubscriptionService;
use Academia\Subscription\Domain\Repositories\SubscriptionServiceRepository;

class SubscriptionServiceRepositoryInMemory implements SubscriptionServiceRepository
{
    private $subscriptionServices = [];
    
    public function getById(string $id): ?SubscriptionService
    {
        foreach ($this->subscriptionServices as $subscriptionService) {
            if ($subscriptionService->getId() == $id) {
                return $subscriptionService;
            }
        }
        return null;
    }

    public function getAll(): ?Array
    {
        return $this->subscriptionServices;
    }

    public function save(SubscriptionService $subscriptionService): ?SubscriptionService
    {
        for ($i = 0; $i < count($this->subscriptionServices); $i++) {
            if ($this->subscriptionServices[$i]->getId() == $subscriptionService->getId()) {
                $this->subscriptionServices[$i] = $subscriptionService;
                return $subscriptionService;
            }
        }
        $this->subscriptionServices[] = $subscriptionService;
        return $subscriptionService;
    }

    public function delete(string $id): bool
    {
        for ($i = 0; $i < count($this->subscriptionServices); $i++) {
            if ($this->subscriptionServices[$i]->getId() == $id) {
                unset($this->subscriptionServices[$i]);
                $this->subscriptionServices = array_values($this->subscriptionServices);
                return true;
            }
        }
        return false;  
    }
}