<?php

namespace Academia\Subscription\Application\Services\Service\UpdateService;

use Academia\Subscription\Domain\Entities\Service;

class UpdateServiceResponseDto
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