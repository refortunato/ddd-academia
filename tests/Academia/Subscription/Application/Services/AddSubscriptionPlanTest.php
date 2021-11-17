<?php

use Academia\Subscription\Application\Services\SubscriptionPlan\AddSubscriptionPlan\AddSubscriptionPlan;
use Academia\Subscription\Application\Services\SubscriptionPlan\AddSubscriptionPlan\AddSubscriptionPlanRequestDto;
use Academia\Subscription\Domain\Enum\DiscountType;
use Academia\Subscription\Infra\Repositories\InMemory\SubscriptionPlanRepositoryInMemory;
use PHPUnit\Framework\TestCase;

final class AddSubscriptionPlanTest extends TestCase
{
    public function testShouldBeOk()
    {
        $subscription_plan_repository = new SubscriptionPlanRepositoryInMemory();
        $add_subscription_plan_request_dto = new AddSubscriptionPlanRequestDto(
            'Mensal',
            1,
            DiscountType::VALUE,
            10
        );
        $use_case = new AddSubscriptionPlan($subscription_plan_repository);
        $add_subscription_plan_response_dto = $use_case->execute($add_subscription_plan_request_dto);
        self::assertNotEmpty($add_subscription_plan_response_dto);
    }
}