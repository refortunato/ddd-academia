<?php

use Academia\Subscription\Application\Services\Service\GetServiceById\GetServiceById;
use Academia\Subscription\Domain\Entities\Service;
use Academia\Subscription\Domain\Repositories\ServiceRepository;
use Academia\Subscription\Infra\Repositories\InMemory\ServiceRepositoryInMemory;
use PHPUnit\Framework\TestCase;

final class GetServiceByIdTest extends TestCase
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

    public function testShouldBeOk()
    {
        $serviceRepository = $this->getRepositoryWithData();
        $use_case = new GetServiceById($serviceRepository);
        $getServiceByIdResponseDto = $use_case->execute('bkioo95g0-86k9-62ix-lk98-ki4s74l79474'); 
        self::assertNotEmpty($getServiceByIdResponseDto->getService());
    }

    public function testShouldThrowNotFoundException()
    {
        $this->expectExceptionMessage("Serviço não foi encontrado na base de dados."); 
        $this->expectException("Academia\Core\Exceptions\NotFoundException");
        $serviceRepository = $this->getRepositoryWithData();
        $use_case = new GetServiceById($serviceRepository);
        $getServiceByIdResponseDto = $use_case->execute('bkioo95g0-86k9-62ix-lk98-ki4s74l79'); 
    }
}