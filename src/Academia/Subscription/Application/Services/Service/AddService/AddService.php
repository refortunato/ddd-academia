<?php

namespace Academia\Subscription\Application\Services\Service\AddService;

use Academia\Subscription\Domain\Entities\Service;
use Academia\Subscription\Domain\Enum\StatusService;
use Academia\Subscription\Domain\Repositories\ServiceRepository;

class AddService
{
    private $serviceRepository;

    public function __construct(ServiceRepository $serviceRepository)
    {
        $this->serviceRepository = $serviceRepository;
    }

    public function execute(AddServiceRequestDto $addServiceRequestDto): AddServiceResponseDto
    {
        $service = new Service(
            '',
            $addServiceRequestDto->getName(),
            $addServiceRequestDto->getPrice()
        );
        if ($addServiceRequestDto->getStatus() === StatusService::ACTIVE) {
            $service->activate();
        }
        elseif ($addServiceRequestDto->getStatus() === StatusService::INACTIVE) {
            $service->deactivate();
        }
        $this->serviceRepository->save($service);

        return new AddServiceResponseDto($service);
    }

}