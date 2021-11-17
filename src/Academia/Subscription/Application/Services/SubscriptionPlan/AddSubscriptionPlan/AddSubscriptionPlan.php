<?php

namespace Academia\Subscription\Application\Services\SubscriptionPlan\AddSubscriptionPlan;

use Academia\Subscription\Domain\Entities\SubscriptionPlan;
use Academia\Subscription\Domain\Repositories\SubscriptionPlanRepository;

class AddSubscriptionPlan
{
    private $subscription_plan_repository;

    public function __construct(SubscriptionPlanRepository $subscription_plan_repository)
    {
        $this->subscription_plan_repository = $subscription_plan_repository;
    }

    public function execute(AddSubscriptionPlanRequestDto $addSubscriptionPlanRequestDto): AddSubscriptionPlanResponseDto
    {
        $subscription_plan = new SubscriptionPlan(
            '',
            $addSubscriptionPlanRequestDto->getName(),
            $addSubscriptionPlanRequestDto->getTotalPlanValidityMonths()
        );
        $subscription_plan->setDiscount(
            $addSubscriptionPlanRequestDto->getDiscountType(), 
            $addSubscriptionPlanRequestDto->getDiscountValue()
        );
        return new AddSubscriptionPlanResponseDto(
            $this->subscription_plan_repository->save($subscription_plan)
        );
    }
}