<?php

use Academia\Register\Application\Services\Customer\GetCustomerById\GetCustomerById;
use Academia\Register\Application\Services\Customer\GetCustomerById\GetCustomerByIdRequestDto;
use Academia\Register\Domain\Entities\Customer;
use Academia\Register\Domain\Enum\StatusCustomer;
use Academia\Register\Infra\Repositories\InMemory\CustomerRepositoryInMemory;
use PHPUnit\Framework\TestCase;

final class GetCustomerByIdTest extends TestCase
{
    public function testShoulReturnCustomer()
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
        $getCustomerByIdRequestDto = new GetCustomerByIdRequestDto(
            '1d3c4f93-96f2-4749-af07-7c7b12d78496'
        );
        $use_case = new GetCustomerById($customerRepository);
        $getCustomerByIdResponseDto = $use_case->execute($getCustomerByIdRequestDto);
        self::assertNotEmpty($getCustomerByIdResponseDto->getCustomer());
        self::assertEquals((string)$getCustomerByIdResponseDto->getCustomer()->getCpf(), '48112765073');
    }

    public function testShouldThrowNotFoundException()
    {
        $this->expectExceptionMessage("Cliente não foi encontrado na base de dados"); 
        $this->expectException("Academia\Core\Exceptions\NotFoundException");
        $customerRepository = new CustomerRepositoryInMemory();
        $getCustomerByIdRequestDto = new GetCustomerByIdRequestDto('');
        $use_case = new GetCustomerById($customerRepository);
        $getCustomerByIdResponseDto = $use_case->execute($getCustomerByIdRequestDto);
    }
}