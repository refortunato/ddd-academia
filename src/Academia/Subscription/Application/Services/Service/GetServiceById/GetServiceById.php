<?php

namespace Academia\Subscription\Application\Services\Service\GetServiceById;

use Academia\Subscription\Domain\Repositories\ServiceRepository;
use Academia\Core\Exceptions\NotFoundException;

class GetServiceById
{
    private $serviceRepository;

    public function __construct(ServiceRepository $serviceRepository)
    {
        $this->serviceRepository = $serviceRepository;
    }

    public function execute(string $id): GetServiceByIdResponseDto
    {
        $service = $this->serviceRepository->getById($id);
        if (empty($service)) {
            throw new NotFoundException("Serviço não foi encontrado na base de dados.");
        }
        $getServiceByIdReponseDto = new GetServiceByIdResponseDto($service);
        return $getServiceByIdReponseDto;
    }
}