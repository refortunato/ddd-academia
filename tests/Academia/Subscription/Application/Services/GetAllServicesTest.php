<?php

use Academia\Subscription\Application\Services\Service\GetAllServices\GetAllServices;
use Academia\Subscription\Domain\Entities\Service;
use Academia\Subscription\Domain\Repositories\ServiceRepository;
use Academia\Subscription\Infra\Repositories\InMemory\ServiceRepositoryInMemory;
use PHPUnit\Framework\TestCase;

final class GetAllServicesTest extends TestCase
{
    private function getRepositoryWithData(): ServiceRepository
    {
        $serviceRepository = new ServiceRepositoryInMemory();
        $service = new Service(
            'ugkh85e3-24r6-63jr-hj58-5l5d08d72564',
            'Musculação',
            95
        );
        $serviceRepository->save($service);
        $service = new Service(
            'bkioo95g0-86k9-62ix-lk98-ki4s74l79474',
            'Natação',
            100
        );
        $serviceRepository->save($service);
        return $serviceRepository;
    }

    public function testShoulBeOk()
    {
        $serviceRepository = $this->getRepositoryWithData();
        $use_case = new GetAllServices($serviceRepository);
        $getAllServicesResponseDto = $use_case->execute(); 
        self::assertNotEmpty($getAllServicesResponseDto->getServices());
        self::assertEquals(count($getAllServicesResponseDto->getServices()), 2);
    }
}