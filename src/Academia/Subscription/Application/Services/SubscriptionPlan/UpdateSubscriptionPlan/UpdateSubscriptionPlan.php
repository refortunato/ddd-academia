<?php

namespace Academia\Subscription\Application\Services\SubscriptionPlan\UpdateSubscriptionPlan;

use Academia\Subscription\Domain\Entities\SubscriptionPlan;
use Academia\Subscription\Domain\Repositories\SubscriptionPlanRepository;
use Academia\Core\Exceptions\NotFoundException;

class UpdateSubscriptionPlan
{
    private $subscription_plan_repository;

    public function __construct(SubscriptionPlanRepository $subscription_plan_repository)
    {
        $this->subscription_plan_repository = $subscription_plan_repository;
    }

    public function execute(UpdateSubscriptionPlanRequestDto $updateSubscriptionPlanRequestDto): UpdateSubscriptionPlanResponseDto
    {
        $subscription_plan = $this->subscription_plan_repository->getById($updateSubscriptionPlanRequestDto->getId());
        if (empty($subscription_plan)) {
            throw new NotFoundException("Plano de inscrição não foi encontrado para alteração.");
        }
        $subscription_plan = new SubscriptionPlan(
            $subscription_plan->getId(),
            $updateSubscriptionPlanRequestDto->getName(),
            $updateSubscriptionPlanRequestDto->getTotalPlanValidityMonths()
        );
        $subscription_plan->setDiscount(
            $updateSubscriptionPlanRequestDto->getDiscountType(), 
            $updateSubscriptionPlanRequestDto->getDiscountValue()
        );
        return new UpdateSubscriptionPlanResponseDto(
            $this->subscription_plan_repository->save($subscription_plan)
        );
    }
}