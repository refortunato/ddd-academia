<?php

namespace Academia\Subscription\Infra\Repositories\InMemory;

use Academia\Subscription\Domain\Entities\SubscriptionPlan;
use Academia\Subscription\Domain\Repositories\SubscriptionPlanRepository;

class SubscriptionPlanRepositoryInMemory implements SubscriptionPlanRepository
{
    private $subscription_plans = [];

    public function getById(string $id): ?SubscriptionPlan
    {
        foreach ($this->subscription_plans as $subscription_plan) {
            if ($subscription_plan->getId() == $id) {
                return $subscription_plan;
            }
        }
        return null;
    }

    public function getAll(): ?Array
    {
        return $this->subscription_plans;
    }

    public function save(SubscriptionPlan $subscription_plan): ?SubscriptionPlan
    {
        for ($i = 0; $i < count($this->subscription_plans); $i++) {
            if ($this->subscription_plans[$i]->getId() == $subscription_plan->getId()) {
                $this->subscription_plans[$i] = $subscription_plan;
                return $subscription_plan;
            }
        }
        $this->subscription_plans[] = $subscription_plan;
        return $subscription_plan;
    }

    public function delete(string $id): bool
    {
        for ($i = 0; $i < count($this->subscription_plans); $i++) {
            if ($this->subscription_plans[$i]->getId() == $id) {
                unset($this->subscription_plans[$i]);
                $this->subscription_plans = array_values($this->subscription_plans);
                return true;
            }
        }
        return false;
    }
}