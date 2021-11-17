<?php

namespace Academia\Subscription\Application\Services\Subscription\CreateSubscription;

use Academia\Subscription\Domain\Entities\Subscription;

class CreateSubscriptionResponseDto
{
    private Subscription $subscription;

    public function __construct(
        Subscription $subscription
    )
    {
        $this->subscription = $subscription;
    }

    public function getSubscription(): Subscription
    {
        return $this->subscription;
    }
}