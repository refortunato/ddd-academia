<?php

namespace Academia\Subscription\Application\Services\Subscription\CreateSubscription;

class CreateSubscriptionRequestDto
{
    private string $customer_id;
    private string $customer_name;
    private string $customer_cpf;
    private string $subscription_plan_id;
    private string $start_date;
    private array $services_id = [];

    public function __construct(
        string $customer_id,
        string $customer_name,
        string $customer_cpf,
        string $subscription_plan_id,
        string $start_date
    )
    {
        $this->customer_id = $customer_id;
        $this->customer_name = $customer_name;
        $this->customer_cpf = $customer_cpf;
        $this->subscription_plan_id = $subscription_plan_id;
        $this->start_date = $start_date;
    }

    public function getCustomerId(): string
    {
        return $this->customer_id;
    }

    public function getCustomerName(): string
    {
        return $this->customer_name;
    }

    public function getCustomerCpf(): string
    {
        return $this->customer_cpf;
    }

    public function getSubscriptionPlanId(): string
    {
        return $this->subscription_plan_id;
    }

    public function getStartDate(): string
    {
        return $this->start_date;
    }

    public function getServicesId(): array
    {
        return $this->services_id;
    }

    /**
     * Setters
     */
    public function addServiceId(string $service_id): void
    {
        $this->services_id[] = $service_id;
    }
}