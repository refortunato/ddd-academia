<?php

use Academia\Register\Application\Services\Customer\RemoveCustomer\RemoveCustomer;
use Academia\Register\Application\Services\Customer\RemoveCustomer\RemoveCustomerRequestDto;
use Academia\Register\Domain\Entities\Customer;
use Academia\Register\Domain\Enum\StatusCustomer;
use Academia\Register\Infra\Repositories\InMemory\CustomerRepositoryInMemory;
use PHPUnit\Framework\TestCase;

final class RemoveCustomerTest extends TestCase
{
    public function testShoulReturnTrue()
    {
        $customerRepository = new CustomerRepositoryInMemory();
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
        $removeCustomerRequestDto = new RemoveCustomerRequestDto(
            '1d3c4f93-96f2-4749-af07-7c7b12d78496'
        );
        $use_case = new RemoveCustomer($customerRepository);
        $removeCustomer = $use_case->execute($removeCustomerRequestDto);
        self::assertTrue($removeCustomer);        
    }

    public function testShoulThrowWhenNotFound()
    {
        $this->expectExceptionMessage("Cliente não foi encontrado para remover."); 
        $this->expectException("Academia\Core\Exceptions\NotFoundException");
        $customerRepository = new CustomerRepositoryInMemory();
        $removeCustomerRequestDto = new RemoveCustomerRequestDto(
            '1d3c4f93-96f2-4749-af07-7c7b12d78496'
        );
        $use_case = new RemoveCustomer($customerRepository);
        $removeCustomer = $use_case->execute($removeCustomerRequestDto);
        //self::assertTrue($removeCustomer);        
    }
}