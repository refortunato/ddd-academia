<?php

namespace Academia\Subscription\Application\Services\Service\UpdateService;

use Academia\Subscription\Domain\Enum\StatusService;
use Academia\Subscription\Domain\Repositories\ServiceRepository;
use Academia\Core\Exceptions\NotFoundException;

class UpdateService
{
    private $serviceRepository;

    public function __construct(ServiceRepository $serviceRepository)
    {
        $this->serviceRepository = $serviceRepository;
    }

    public function execute(UpdateServiceRequestDto $updateServiceRequestDto): UpdateServiceResponseDto
    {
        $service = $this->serviceRepository->getById($updateServiceRequestDto->getId());
        if (empty($service)) {
            throw new NotFoundException("Serviço não foi encontrado.");
        }
        $service->setName($updateServiceRequestDto->getName());
        $service->setPrice($updateServiceRequestDto->getPrice());
        if ($updateServiceRequestDto->getStatus() === StatusService::ACTIVE) {
            $service->activate();
        }
        else if ($updateServiceRequestDto->getStatus() === StatusService::INACTIVE) {
            $service->deactivate();
        }
        $this->serviceRepository->save($service);

        return new UpdateServiceResponseDto($service);
    }
}