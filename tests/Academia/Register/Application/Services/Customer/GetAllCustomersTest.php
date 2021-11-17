<?php

use Academia\Register\Application\Services\Customer\GetAllCustomers\GetAllCustomers;
use Academia\Register\Domain\Entities\Customer;
use Academia\Register\Domain\Enum\StatusCustomer;
use Academia\Register\Infra\Repositories\InMemory\CustomerRepositoryInMemory;
use PHPUnit\Framework\TestCase;

final class GetAllCustomersTest extends TestCase
{
    public function testShouldBeOk()
    {
        $customerRepository = new CustomerRepositoryInMemory();
        $customerRepository->save(
            Customer::create(
                'v45h4f93-96f2-25gy-gn34-7c7b12d73145',
                'Albert',
                'Nillman',
                '387.914.510-51',
                '07/07/1995',
                StatusCustomer::ACTIVE,
                'albert@mail.com',
                ''
            )
        );
        $customerRepository->save(
            Customer::create(
                '1d3c4f93-96f2-4749-af07-7c7b12d78496',
                'John',
                'Doe',
                '481.127.650-73',
                '15/11/1990',
                StatusCustomer::ACTIVE,
                'john@mail.com',
                ''
            )
        );
        $use_case = new GetAllCustomers($customerRepository);
        $getAllCustomersResponseDto = $use_case->execute(); 
        self::assertNotEmpty($getAllCustomersResponseDto->getCustomers());
        self::assertEquals(count($getAllCustomersResponseDto->getCustomers()), 2);
    }
}