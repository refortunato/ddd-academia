<?php

namespace Academia\Subscription\Application\Services\Service\GetAllServices;

use Academia\Subscription\Domain\Entities\Service;

class GetAllServicesResponseDto
{
    private $services = [];

    public function addService(Service $service)
    {
        $this->services[] = $service;
    }

    public function getServices()
    {
        return $this->services;
    }
}