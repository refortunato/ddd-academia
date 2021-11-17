<?php

namespace Academia\Subscription\Application\Services\Service\AddService;

use Academia\Subscription\Domain\Entities\Service;

class AddServiceResponseDto
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