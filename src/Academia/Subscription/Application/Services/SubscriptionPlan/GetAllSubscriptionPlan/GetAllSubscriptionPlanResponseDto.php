<?php

namespace Academia\Subscription\Application\Services\SubscriptionPlan\GetAllSubscriptionPlan;

use Academia\Subscription\Domain\Entities\SubscriptionPlan;

class GetAllSubscriptionPlanResponseDto
{
    private $subscriptionPlans = [];

    public function addSubscriptionPlan(SubscriptionPlan $subscriptionPlan)
    {
        $this->subscriptionPlans[] = $subscriptionPlan;
    }

    public function getSubscriptionPlans()
    {
        return $this->subscriptionPlans;
    }
}