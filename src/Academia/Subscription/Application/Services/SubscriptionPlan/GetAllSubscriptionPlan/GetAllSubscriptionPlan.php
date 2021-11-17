<?php

namespace Academia\Subscription\Application\Services\SubscriptionPlan\GetAllSubscriptionPlan;

use Academia\Subscription\Domain\Repositories\SubscriptionPlanRepository;
use Academia\Core\Exceptions\NotFoundException;

class GetAllSubscriptionPlan
{
    private $subscription_plan_repository;

    public function __construct(SubscriptionPlanRepository $subscription_plan_repository)
    {
        $this->subscription_plan_repository = $subscription_plan_repository;
    }

    public function execute() : GetAllSubscriptionPlanResponseDto
    {
        $subscriptionPlans = $this->subscription_plan_repository->getAll();
        if (empty($subscriptionPlans)) {
            throw new NotFoundException("Não foram encontrados planos de inscrição.");
        }
        $getAllSubscriptionPlanResponseDto = new GetAllSubscriptionPlanResponseDto();
        foreach ($subscriptionPlans as $subscription_plan) {
            $getAllSubscriptionPlanResponseDto->addSubscriptionPlan($subscription_plan);
        }
        return $getAllSubscriptionPlanResponseDto;
    }
}