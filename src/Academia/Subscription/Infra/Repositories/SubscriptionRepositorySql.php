<?php

namespace Academia\Subscription\Infra\Repositories;

use Academia\Core\Entity;
use Academia\Core\Infra\DB\DataMapper\Drivers\DriverInterface;
use Academia\Core\Infra\DB\DataMapper\Repositories\Repository;
use Academia\Subscription\Domain\Entities\Subscription;
use Academia\Subscription\Domain\Entities\SubscriptionPlan;
use Academia\Subscription\Domain\Repositories\SubscriptionPlanRepository;
use Academia\Subscription\Domain\Repositories\SubscriptionRepository;
use Academia\Subscription\Domain\Repositories\SubscriptionServiceRepository;
use Academia\Subscription\Mappers\SubscriptionMap;
use Academia\Subscription\Mappers\SubscriptionPlanMap;

class SubscriptionRepositorySql extends Repository implements SubscriptionRepository
{
    private SubscriptionServiceRepository $subscriptionServiceRepository;
    private SubscriptionPlanRepository $subscriptionPlanRepository;

    protected ?string $table = 'subscription';

    public function __construct(DriverInterface $driver)
    {
        parent::__construct($driver);
        $this->subscriptionServiceRepository = new SubscriptionServiceRepositorySql($driver);
        $this->subscriptionPlanRepository = new SubscriptionPlanRepositorySql($driver);
    }

    protected function makeEntity(array $fields): ?Entity
    {
        $subscription_plan = $this->subscriptionPlanRepository->getById($fields['subscription_plan_id']);
        return SubscriptionMap::toEntity($fields, $subscription_plan);
    }

    protected function mapEntityToArrayFields(Entity $customer): array
    {
        return SubscriptionMap::toPersistance($customer);
    }

    public function getById(string $id): ?Subscription
    {
        $subscription = $this->first($id);
        if (! empty($subscription)) {
            $subscription_services_array = $this->subscriptionServiceRepository->getAll([0 =>['subscription_id', $subscription->getId()]]);
            foreach ($subscription_services_array as $subscription_service) {
                $subscription->addSubscriptionService($subscription_service);
            }
        }
        return $subscription;
    }

    public function save(Subscription $subscription): ?Subscription
    {
        $exists = $this->first($subscription->getId()) ? true : false;
        if ($exists) {
            $this->update($subscription);
        }
        else {
            $this->insert($subscription);
        }      
        foreach ($subscription->getSubscriptionServices() as $subscription_service) {
            $this->subscriptionServiceRepository->save($subscription_service);
        }
        //foreach ($subscription->getServices() as $service) {
        //    $this->serviceRepository->save($service);
        //}
        return $subscription;
    }

    public function getAll(array $condition = []): ?array
    {
        return $this->all($condition);
    }

    public function getFromCustomer(string $customer_id): ?Array
    {
        $conditions = [];
        $conditions[] = ['customer_id', $customer_id];
        return $this->all($conditions);
    }
}