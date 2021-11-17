<?php

namespace Academia\Subscription\Application\Services\SubscriptionPlan\GetSubscriptionPlanById;

use Academia\Subscription\Application\Services\SubscriptionPlan\GetSubscriptionPlanById\GetSubscriptionPlanByIdResponseDto;
use Academia\Subscription\Domain\Repositories\SubscriptionPlanRepository;
use Academia\Core\Exceptions\NotFoundException;

class GetSubscriptionPlanById
{
    private $subscription_plan_repository;

    public function __construct(SubscriptionPlanRepository $subscription_plan_repository)
    {
        $this->subscription_plan_repository = $subscription_plan_repository;
    }

    public function execute(string $id) : GetSubscriptionPlanByIdResponseDto
    {
        $subscription_plan = $this->subscription_plan_repository->getById($id);
        if (empty($subscription_plan)) {
            throw new NotFoundException("Plano de inscrição não foi encontrado.");
        }
        $getSubscriptionPlanByIdResponseDto = new GetSubscriptionPlanByIdResponseDto($subscription_plan);
        return $getSubscriptionPlanByIdResponseDto;
    }
}