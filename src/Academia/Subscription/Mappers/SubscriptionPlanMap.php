<?php

namespace Academia\Subscription\Mappers;

use Academia\Subscription\Domain\Entities\SubscriptionPlan;

class SubscriptionPlanMap
{
    public static function toArray(SubscriptionPlan $subscriptionPlan): array
    {
        $array = [];
        $array['id'] = $subscriptionPlan->getId();
        $array['name'] = $subscriptionPlan->getName();
        $array['total_plan_validity_months'] = $subscriptionPlan->getTotalPlanValidityMonth();
        $array['discount_type'] = $subscriptionPlan->getDiscountType();
        $array['discount_value'] = $subscriptionPlan->getDiscountValue();
        
        return $array;
    }

    public static function toPersistance(SubscriptionPlan $subscriptionPlan): array
    {
        $array = [];
        $array['id'] = $subscriptionPlan->getId();
        $array['name'] = $subscriptionPlan->getName();
        $array['total_plan_validity_months'] = $subscriptionPlan->getTotalPlanValidityMonth();
        $array['discount_type'] = $subscriptionPlan->getDiscountType();
        $array['discount_value'] = $subscriptionPlan->getDiscountValue();
        
        return $array;
    }

    public static function toEntity(array $fields): ?SubscriptionPlan
    {
        $subscriptionPlan =  new SubscriptionPlan(
            $fields['id'],
            $fields['name'],
            $fields['total_plan_validity_months']
        );

        if (! empty($fields['discount_type']) && ! empty($fields['discount_value'])) {
            $subscriptionPlan->setDiscount($fields['discount_type'], $fields['discount_value']);
        }

        return $subscriptionPlan;
    }
}