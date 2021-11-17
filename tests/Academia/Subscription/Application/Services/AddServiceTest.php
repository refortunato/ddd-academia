<?php

use Academia\Subscription\Application\Services\Service\AddService\AddService;
use Academia\Subscription\Application\Services\Service\AddService\AddServiceRequestDto;
use Academia\Subscription\Domain\Enum\StatusService;
use Academia\Subscription\Infra\Repositories\InMemory\ServiceRepositoryInMemory;
use PHPUnit\Framework\TestCase;

final class AddServiceTest extends TestCase
{
    public function testShouldBeOk()
    {
        $serviceRepository = new ServiceRepositoryInMemory();
        $addServiceRequestDto = new AddServiceRequestDto(
            'Musculação',
            95,
            StatusService::ACTIVE
        );
        $use_case = new AddService($serviceRepository);
        $addServiceResponseDto = $use_case->execute($addServiceRequestDto);
        self::assertNotEmpty($addServiceResponseDto->getService());
    }

    public function testShouldThrowWhenStatusServiceIsOutOfEnum()
    {
        $this->expectExceptionMessage("Status do serviço é inválido"); 
        $this->expectException("DomainException");
        $serviceRepository = new ServiceRepositoryInMemory();
        $addServiceRequestDto = new AddServiceRequestDto(
            'Musculação',
            95,
            'Testing'
        );
        $use_case = new AddService($serviceRepository);
        $addServiceResponseDto = $use_case->execute($addServiceRequestDto);
        self::assertNotEmpty($addServiceResponseDto->getService());
    }
}