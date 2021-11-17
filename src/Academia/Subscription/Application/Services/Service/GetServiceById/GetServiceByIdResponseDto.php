<?php

namespace Academia\Subscription\Application\Services\Service\GetServiceById;

use Academia\Subscription\Domain\Entities\Service;

class GetServiceByIdResponseDto
{
    private $service;

    public function __construct(Service $service)
    {
        $this->service = $service;
    }

    public function getService(): Service
    {
        return $this->service;
    }
}