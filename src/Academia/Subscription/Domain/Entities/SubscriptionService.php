<?php

namespace Academia\Subscription\Domain\Entities;

use Academia\Core\Entity;

class SubscriptionService extends Entity
{
    private string $subscription_id;
    private string $service_id;
    private string $service_name;
    private float $service_value;

    public function __construct(
        string $id,
        string $subscription_id,
        string $service_id,
        string $service_name,
        float $service_value
    )
    {
        parent::__construct($id);
        $this->subscription_id = $subscription_id;
        $this->service_id = $service_id;
        $this->service_name = $service_name;
        $this->service_value = round($service_value, 2);
    }

    public function getSubscriptionId(): string
    {
        return $this->subscription_id;
    }

    public function getServiceId(): string
    {
        return $this->service_id;
    }

    public function getServiceName(): string
    {
        return $this->service_name;
    }

    public function getServiceValue(): float
    {
        return $this->service_value;
    }
}