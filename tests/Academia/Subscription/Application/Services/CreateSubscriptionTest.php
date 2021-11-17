<?php

use Academia\Subscription\Application\Services\Subscription\CreateSubscription\CreateSubscription;
use Academia\Subscription\Application\Services\Subscription\CreateSubscription\CreateSubscriptionRequestDto;
use Academia\Subscription\Application\Services\Subscription\CreateSubscription\CreateSubscriptionResponseDto;
use Academia\Subscription\Domain\Entities\Service;
use Academia\Subscription\Domain\Entities\SubscriptionPlan;
use Academia\Subscription\Domain\Enum\DiscountType;
use Academia\Subscription\Domain\Repositories\ServiceRepository;
use Academia\Subscription\Domain\Repositories\SubscriptionPlanRepository;
use Academia\Subscription\Infra\Repositories\InMemory\ServiceRepositoryInMemory;
use Academia\Subscription\Infra\Repositories\InMemory\SubscriptionPlanRepositoryInMemory;
use Academia\Subscription\Infra\Repositories\InMemory\SubscriptionRepositoryInMemory;
use PHPUnit\Framework\TestCase;

class CreateSubscriptionTest extends TestCase
{
    public function testShouldBeOk()
    {
        $serviceRepository = $this->getServiceRepositoryWithData();
        $subscriptionPlanRepository = $this->getSubscriptionPlanRepositoryWithData();
        $subscriptionRepository = new SubscriptionRepositoryInMemory();
        $createSubscription = new CreateSubscription(
            $subscriptionRepository,
            $subscriptionPlanRepository,
            $serviceRepository
        );
        $createSubscriptionRequestDto = new CreateSubscriptionRequestDto(
            'lkou54r2-23t4-vf48-je19-9c8g08d43684',
            'Any Customer',
            '433.072.230-54',
            'gkoew53g7-52g1-24fr-hj58-5l5d08d52367',
            '2021-08-15'
        );
        $createSubscriptionRequestDto->addServiceId('ugkh85e3-24r6-63jr-hj58-5l5d08d72564');
        $createSubscriptionResponseDto = $createSubscription->execute($createSubscriptionRequestDto);
        self::assertNotEmpty($createSubscriptionResponseDto->getSubscription());
        self::assertEquals($createSubscriptionResponseDto->getSubscription()->getCustomerCpf(), '433.072.230-54');
        //echo PHP_EOL. "Valor Total: " .$createSubscriptionResponseDto->getSubscription()->getTotalValue() . PHP_EOL;
    }

    public function testShouldThrowWhenHasNoService()
    {
        $this->expectExceptionMessage("Ao menos 1 serviço deve ser informado para criar a inscrição"); 
        $this->expectException("DomainException");
        $serviceRepository = $this->getServiceRepositoryWithData();
        $subscriptionPlanRepository = $this->getSubscriptionPlanRepositoryWithData();
        $subscriptionRepository = new SubscriptionRepositoryInMemory();
        $createSubscription = new CreateSubscription(
            $subscriptionRepository,
            $subscriptionPlanRepository,
            $serviceRepository
        );
        $createSubscriptionRequestDto = new CreateSubscriptionRequestDto(
            'lkou54r2-23t4-vf48-je19-9c8g08d43684',
            'Any Customer',
            '433.072.230-54',
            'gkoew53g7-52g1-24fr-hj58-5l5d08d52367',
            '2021-08-15'
        );
        $createSubscriptionResponseDto = $createSubscription->execute($createSubscriptionRequestDto);
    }

    private function getServiceRepositoryWithData(): ServiceRepository
    {
        $serviceRepository = new ServiceRepositoryInMemory();
        $service = new Service(
            'ugkh85e3-24r6-63jr-hj58-5l5d08d72564',
            'Musculação',
            100
        );
        $serviceRepository->save($service);
        return $serviceRepository;
    }

    private function getSubscriptionPlanRepositoryWithData(): SubscriptionPlanRepository
    {
        $subscriptionPlanRepository = new SubscriptionPlanRepositoryInMemory();
        $subscription_plan = new SubscriptionPlan(
            'gkoew53g7-52g1-24fr-hj58-5l5d08d52367',
            'Mensal',
            1
        );
        $subscription_plan->setDiscount(DiscountType::VALUE, 10);
        $subscriptionPlanRepository->save($subscription_plan);
        return $subscriptionPlanRepository;
    }
}