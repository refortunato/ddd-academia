<?php

namespace Academia\Subscription\Mappers;

use Academia\Subscription\Domain\Entities\SubscriptionService;

class SubscriptionServiceMap
{
    public static function toArray(SubscriptionService $subscription_service): array
    {
        $array = [];
        $array['id'] = $subscription_service->getId();
        $array['subscription_id'] = $subscription_service->getSubscriptionId();
        $array['service_id'] = $subscription_service->getServiceId();
        $array['service_name'] = $subscription_service->getServiceName();
        $array['service_value'] = $subscription_service->getServiceValue();
        
        return $array;
    }

    public static function toPersistance(SubscriptionService $subscription_service): array
    {
        $array = [];
        $array['id'] = $subscription_service->getId();
        $array['subscription_id'] = $subscription_service->getSubscriptionId();
        $array['service_id'] = $subscription_service->getServiceId();
        $array['service_name'] = $subscription_service->getServiceName();
        $array['service_value'] = $subscription_service->getServiceValue();
        
        return $array;
    }

    public static function toEntity(array $fields): ?SubscriptionService
    {
        return new SubscriptionService(
            $fields['id'],
            $fields['subscription_id'],
            $fields['service_id'],
            $fields['service_name'],
            $fields['service_value']
        );
    }
}