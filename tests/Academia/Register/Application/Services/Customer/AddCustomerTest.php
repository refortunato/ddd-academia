<?php

use Academia\Register\Application\Services\Customer\AddCustomer\AddCustomer;
use Academia\Register\Application\Services\Customer\AddCustomer\AddCustomerRequestDto;
use Academia\Register\Domain\Enum\StatusCustomer;
use Academia\Register\Infra\Repositories\InMemory\CustomerRepositoryInMemory;
use PHPUnit\Framework\TestCase;

final class AddCustomerTest extends TestCase
{
    public function testAddCustomerMustBeOk()
    {
        $customerRepository = new CustomerRepositoryInMemory();
        $addCustomerRequestDto = new AddCustomerRequestDto(
            'any_name',
            'any_last_name',
            '783.604.070-45',
            '16/08/1997',
            StatusCustomer::ACTIVE,
            'any@mail.com',
            ''
        );
        $use_case = new AddCustomer($customerRepository);
        $customerResponseDto = $use_case->execute($addCustomerRequestDto); 
         
        self::assertNotEmpty($customerResponseDto->getCustomer());
        self::assertEquals((string)$customerResponseDto->getCustomer()->getCpf(), '78360407045');
    }
}