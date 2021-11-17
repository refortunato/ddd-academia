<?php

namespace Academia\Subscription\Mappers;

use Academia\Subscription\Domain\Entities\Service;

class ServiceMap
{
    public static function toArray(Service $service): array
    {
        $array = [];
        $array['id'] = $service->getId();
        $array['name'] = $service->getName();
        $array['price'] = $service->getPrice();
        $array['status'] = $service->getStatus();
        
        return $array;
    }

    public static function toPersistance(Service $service): array
    {
        $array = [];
        $array['id'] = $service->getId();
        $array['name'] = $service->getName();
        $array['price'] = $service->getPrice();
        $array['status'] = $service->getStatus();

        return $array;
    }

    public static function toEntity(array $fields): ?Service
    {
        return new Service(
            $fields['id'],
            $fields['name'],
            $fields['price'],
            $fields['status']
        );
    }
}