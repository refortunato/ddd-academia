<?php

namespace Academia\Subscription\Application\Services\SubscriptionPlan\GetSubscriptionPlanById;

use Academia\Subscription\Domain\Entities\Service;
use Academia\Subscription\Domain\Entities\SubscriptionPlan;

class GetSubscriptionPlanByIdResponseDto
{
    private $subscription_plan;

    public function __construct(
        SubscriptionPlan $subscription_plan
    )
    {
        $this->subscription_plan = $subscription_plan;
    }

    public function getSubscriptionPlan(): SubscriptionPlan
    {
        return $this->subscription_plan;
    }
}