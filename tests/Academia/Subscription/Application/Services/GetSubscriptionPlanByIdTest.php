<?php

use Academia\Subscription\Application\Services\SubscriptionPlan\GetSubscriptionPlanById\GetSubscriptionPlanById;
use Academia\Subscription\Domain\Entities\SubscriptionPlan;
use Academia\Subscription\Domain\Enum\DiscountType;
use Academia\Subscription\Domain\Repositories\SubscriptionPlanRepository;
use Academia\Subscription\Infra\Repositories\InMemory\SubscriptionPlanRepositoryInMemory;
use PHPUnit\Framework\TestCase;

final class GetSubscriptionPlanByIdTest extends TestCase
{
    private function getRepositoryWithData(): SubscriptionPlanRepository
    {
        $subscriptionPlanRepository = new SubscriptionPlanRepositoryInMemory();
        $subscription_plan = new SubscriptionPlan(
            'ugkh85e3-24r6-63jr-hj58-5l5d08d72564',
            'Mensal',
            1
        );
        $subscription_plan->setDiscount(DiscountType::VALUE, 10);
        $subscriptionPlanRepository->save($subscription_plan);
        $subscription_plan = new SubscriptionPlan(
            'bkioo95g0-86k9-62ix-lk98-ki4s74l79474',
            'Trimestral',
            3
        );
        $subscription_plan->setDiscount(DiscountType::PERCENT, 5);
        $subscriptionPlanRepository->save($subscription_plan);
        return $subscriptionPlanRepository;
    }

    public function testShouldBeOk()
    {
        $subscriptionPlanRepository = $this->getRepositoryWithData();
        $use_case = new GetSubscriptionPlanById($subscriptionPlanRepository);
        $getSubscriptionPlanByIdResponseDto = $use_case->execute('bkioo95g0-86k9-62ix-lk98-ki4s74l79474'); 
        self::assertNotEmpty($getSubscriptionPlanByIdResponseDto->getSubscriptionPlan());
        self::assertEquals($getSubscriptionPlanByIdResponseDto->getSubscriptionPlan()->getName(), 'Trimestral');
    }
}