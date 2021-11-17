<?php

use Academia\Subscription\Application\Services\SubscriptionPlan\UpdateSubscriptionPlan\UpdateSubscriptionPlan;
use Academia\Subscription\Application\Services\SubscriptionPlan\UpdateSubscriptionPlan\UpdateSubscriptionPlanRequestDto;
use Academia\Subscription\Domain\Entities\SubscriptionPlan;
use Academia\Subscription\Domain\Enum\DiscountType;
use Academia\Subscription\Domain\Enum\SubscriptionDiscountType;
use Academia\Subscription\Domain\Repositories\SubscriptionPlanRepository;
use Academia\Subscription\Infra\Repositories\InMemory\SubscriptionPlanRepositoryInMemory;
use PHPUnit\Framework\TestCase;

final class UpdateSubscriptionPlanTest extends TestCase
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
        return $subscriptionPlanRepository;
    }

    public function testShouldBeOk()
    {
        $subscriptionPlanRepository = $this->getRepositoryWithData();
        $updateSubscriptionPlanRequestDto = new UpdateSubscriptionPlanRequestDto(
            'ugkh85e3-24r6-63jr-hj58-5l5d08d72564',
            'Trimestral',
            3,
            DiscountType::PERCENT,
            5
        );
        $use_case = new UpdateSubscriptionPlan($subscriptionPlanRepository);
        $updateSubscriptionPlanResponseDto = $use_case->execute($updateSubscriptionPlanRequestDto);
        self::assertNotEmpty($updateSubscriptionPlanResponseDto->getSubscriptionPlan());
        self::assertEquals('Trimestral', $updateSubscriptionPlanResponseDto->getSubscriptionPlan()->getName());
        self::assertEquals(3, $updateSubscriptionPlanResponseDto->getSubscriptionPlan()->getTotalPlanValidityMonth());
        self::assertEquals(DiscountType::PERCENT, $updateSubscriptionPlanResponseDto->getSubscriptionPlan()->getDiscountType());
        self::assertEquals(5, $updateSubscriptionPlanResponseDto->getSubscriptionPlan()->getDiscountValue());
    }

    public function testShouldThrowWhenNotFound()
    {
        $this->expectExceptionMessage("Plano de inscrição não foi encontrado para alteração."); 
        $this->expectException("Academia\Core\Exceptions\NotFoundException");
        $subscriptionPlanRepository = $this->getRepositoryWithData();
        $updateSubscriptionPlanRequestDto = new UpdateSubscriptionPlanRequestDto(
            'ugkh85e3',
            'Trimestral',
            3,
            DiscountType::PERCENT,
            5
        );
        $use_case = new UpdateSubscriptionPlan($subscriptionPlanRepository);
        $updateSubscriptionPlanResponseDto = $use_case->execute($updateSubscriptionPlanRequestDto);
    }
}