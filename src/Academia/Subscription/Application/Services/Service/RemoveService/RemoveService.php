<?php

namespace Academia\Subscription\Application\Services\Service\RemoveService;

use Academia\Subscription\Domain\Repositories\ServiceRepository;

class RemoveService
{
    private $serviceRepository;

    public function __construct(ServiceRepository $serviceRepository)
    {
        $this->serviceRepository = $serviceRepository;
    }

    public function execute(string $id): void
    {
        $this->serviceRepository->delete($id);
    }
}
