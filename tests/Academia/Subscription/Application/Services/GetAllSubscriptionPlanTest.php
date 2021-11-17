<?php

use Academia\Subscription\Application\Services\SubscriptionPlan\GetAllSubscriptionPlan\GetAllSubscriptionPlan;
use Academia\Subscription\Domain\Entities\SubscriptionPlan;
use Academia\Subscription\Domain\Enum\DiscountType;
use Academia\Subscription\Domain\Repositories\SubscriptionPlanRepository;
use Academia\Subscription\Infra\Repositories\InMemory\SubscriptionPlanRepositoryInMemory;
use PHPUnit\Framework\TestCase;

final class GetAllSubscriptionPlanTest extends TestCase
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

    public function testShoulBeOk()
    {
        $subscriptionPlanRepository = $this->getRepositoryWithData();
        $use_case = new GetAllSubscriptionPlan($subscriptionPlanRepository);
        $getAllSubscriptionPlanResponseDto = $use_case->execute(); 
        self::assertNotEmpty($getAllSubscriptionPlanResponseDto->getSubscriptionPlans());
        self::assertEquals(count($getAllSubscriptionPlanResponseDto->getSubscriptionPlans()), 2);
    }

    public function shouldThrowWhenNotFound()
    {
        $this->expectExceptionMessage("Não foram encontrados planos de inscrição."); 
        $this->expectException("Academia\Core\Exceptions\NotFoundException");
        $subscriptionPlanRepository = $this->getRepositoryWithData();
        $use_case = new GetAllSubscriptionPlan($subscriptionPlanRepository);
        $getAllSubscriptionPlanResponseDto = $use_case->execute();
    }
}