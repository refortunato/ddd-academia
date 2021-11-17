<?php

namespace Academia\Subscription\Application\Services\SubscriptionPlan\RemoveSubscriptionPlan;

use Academia\Subscription\Domain\Repositories\SubscriptionPlanRepository;

class RemoveSubscriptionPlan
{
    private $subscription_plan_repository;

    public function __construct(SubscriptionPlanRepository $subscription_plan_repository)
    {
        $this->subscription_plan_repository = $subscription_plan_repository;
    }

    public function execute(string $id): void
    {
        $this->subscription_plan_repository->delete($id);
    }
}