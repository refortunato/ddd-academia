<?php

use Academia\Register\Application\Services\Customer\UpdateCustomer\UpdateCustomer;
use Academia\Register\Application\Services\Customer\UpdateCustomer\UpdateCustomerRequestDto;
use Academia\Register\Domain\Entities\Customer;
use Academia\Register\Domain\Enum\StatusCustomer;
use Academia\Register\Infra\Repositories\InMemory\CustomerRepositoryInMemory;
use PHPUnit\Framework\TestCase;

final class UpdateCustomerTest extends TestCase
{
    public function testUpdateCustomerMustBeOk()
    {
        $customerRepository = new CustomerRepositoryInMemory();
        $customerRepository->save(Customer::create(
            'v45h4f93-96f2-25gy-gn34-7c7b12d73145',
            'Albert',
            'Nillman',
            '387.914.510-51',
            '07/07/1995',
            StatusCustomer::ACTIVE,
            'albert@mail.com',
            ''
        ));
        $updateCustomerRequestDto = new UpdateCustomerRequestDto(
            'v45h4f93-96f2-25gy-gn34-7c7b12d73145',
            'any_name',
            'any_last_name',
            '783.604.070-45',
            '16/08/1997',
            StatusCustomer::ACTIVE,
            'any@mail.com',
            ''
        );
        $use_case = new UpdateCustomer($customerRepository);
        $updateCustomerResponseDto = $use_case->execute($updateCustomerRequestDto); 
        self::assertNotEmpty($updateCustomerResponseDto->getCustomer());
        self::assertEquals((string)$updateCustomerResponseDto->getCustomer()->getCpf(), '78360407045');
    }

    public function testShouldThrowNotFoundException()
    {
        $this->expectExceptionMessage("Cliente não foi encontrado para alteração"); 
        $this->expectException("Academia\Core\Exceptions\NotFoundException");
        $customerRepository = new CustomerRepositoryInMemory();
        $updateCustomerRequestDto = new UpdateCustomerRequestDto(
            'v45h4f93-96f2-25gy-gn34-7c7b12d73145',
            'any_name',
            'any_last_name',
            '783.604.070-45',
            '16/08/1997',
            StatusCustomer::ACTIVE,
            'any@mail.com',
            ''
        );
        $use_case = new UpdateCustomer($customerRepository);
        $updateCustomerResponseDto = $use_case->execute($updateCustomerRequestDto);
    }
}