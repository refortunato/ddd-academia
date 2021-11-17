<?php

namespace Academia\Subscription\Application\Services\SubscriptionPlan\AddSubscriptionPlan;

class AddSubscriptionPlanRequestDto
{
    private string $name;
    private int $total_plan_validity_months;
    private string $discount_type;
    private float $discount_value;

    public function __construct(
        string $name,
        int $total_plan_validity_months,
        string $discount_type,
        float $discount_value
    )
    {
        $this->name = $name;
        $this->total_plan_validity_months = $total_plan_validity_months;
        $this->discount_type = $discount_type;
        $this->discount_value = $discount_value;   
    }

    public function getName()
    {
        return $this->name;
    }

    public function getTotalPlanValidityMonths()
    {
        return $this->total_plan_validity_months;
    }

    public function getDiscountType()
    {
        return $this->discount_type;
    }

    public function getDiscountValue()
    {
        return $this->discount_value;
    }

}

