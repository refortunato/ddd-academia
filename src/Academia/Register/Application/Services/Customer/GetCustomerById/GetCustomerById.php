<?php

namespace Academia\Register\Application\Services\Customer\GetCustomerById;

use Academia\Core\Exceptions\NotFoundException;
use Academia\Register\Domain\Repositories\CustomerRepository;

class GetCustomerById
{
    private $customer_repository;

    public function __construct(CustomerRepository $customer_repository)
    {
        $this->customer_repository = $customer_repository;
    }

    public function execute(GetCustomerByIdRequestDto $getCustomerByIdRequestDto): GetCustomerByIdResponseDto
    {
        $customer = $this->customer_repository->getById($getCustomerByIdRequestDto->getId());
        if (empty($customer)) {
            throw new NotFoundException("Cliente não foi encontrado na base de dados");
        }
        $getCustomerByIdResponseDto = new GetCustomerByIdResponseDto($customer);
        return $getCustomerByIdResponseDto;
    }
}