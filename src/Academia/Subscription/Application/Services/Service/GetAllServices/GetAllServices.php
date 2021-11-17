<?php

namespace Academia\Subscription\Application\Services\Service\GetAllServices;

use Academia\Subscription\Domain\Repositories\ServiceRepository;
use Academia\Core\Exceptions\NotFoundException;

class GetAllServices
{
    private $serviceRepository;

    public function __construct(ServiceRepository $serviceRepository)
    {
        $this->serviceRepository = $serviceRepository;
    }

    public function execute() : GetAllServicesResponseDto
    {
        $services = $this->serviceRepository->getAll();
        if (empty($services)) {
            throw new NotFoundException("Sem serviços adicionados.");
        }
        $getAllServicesResponseDto = new GetAllServicesResponseDto();
        foreach ($services as $service) {
            $getAllServicesResponseDto->addService($service);
        }
        return $getAllServicesResponseDto;
    }
}