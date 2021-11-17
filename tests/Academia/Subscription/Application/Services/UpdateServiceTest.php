<?php

use Academia\Subscription\Application\Services\Service\UpdateService\UpdateService;
use Academia\Subscription\Application\Services\Service\UpdateService\UpdateServiceRequestDto;
use Academia\Subscription\Domain\Entities\Service;
use Academia\Subscription\Domain\Enum\StatusService;
use Academia\Subscription\Domain\Repositories\ServiceRepository;
use Academia\Subscription\Infra\Repositories\InMemory\ServiceRepositoryInMemory;
use PHPUnit\Framework\TestCase;

final class UpdateServiceTest extends TestCase
{
    private function getRepositoryWithData(): ServiceRepository
    {
        $serviceRepository = new ServiceRepositoryInMemory();
        $service = new Service(
            'ugkh85e3-24r6-63jr-hj58-5l5d08d72564',
            'Musculação',
            100
        );
        $serviceRepository->save($service);
        return $serviceRepository;
    }

    public function testShouldBeOk()
    {
        $serviceRepository = $this->getRepositoryWithData();
        $updateServiceRequestDto = new UpdateServiceRequestDto(
            'ugkh85e3-24r6-63jr-hj58-5l5d08d72564',
            'Natação',
            95,
            StatusService::INACTIVE
        );
        $use_case = new UpdateService($serviceRepository);
        $updateServiceResponseDto = $use_case->execute($updateServiceRequestDto);
        self::assertNotEmpty($updateServiceResponseDto->getService());
        self::assertEquals('Natação', $updateServiceResponseDto->getService()->getName());
        self::assertEquals(95, $updateServiceResponseDto->getService()->getPrice());
        self::assertEquals(StatusService::INACTIVE, $updateServiceResponseDto->getService()->getStatus());
    }

    public function testShouldThrowWhenServiceNotFound()
    {
        $this->expectExceptionMessage("Serviço não foi encontrado."); 
        $this->expectException("Academia\Core\Exceptions\NotFoundException");
        $serviceRepository = $this->getRepositoryWithData();
        $updateServiceRequestDto = new UpdateServiceRequestDto(
            '1',
            'Natação',
            95,
            StatusService::INACTIVE
        );
        $use_case = new UpdateService($serviceRepository);
        $updateServiceResponseDto = $use_case->execute($updateServiceRequestDto);
    }
}