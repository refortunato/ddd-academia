<?php

namespace Academia\Register\Application\Services\Customer\GetAllCustomers;

use Academia\Core\Exceptions\NotFoundException;
use Academia\Register\Domain\Repositories\CustomerRepository;

class GetAllCustomers
{
    private CustomerRepository $customerRepository;

    public function __construct(
        CustomerRepository $customerRepository
    )
    {
        $this->customerRepository = $customerRepository;
    }

    public function execute(): GetAllCustomersResponseDto
    {
        $customers = $this->customerRepository->getAll();
        if (empty($customers)) {
            throw new NotFoundException("Sem clientes adicionados.");
        }
        $getAllCustomersResponseDto = new GetAllCustomersResponseDto();
        foreach ($customers as $customer) {
            $getAllCustomersResponseDto->addCustomer($customer);
        }
        return $getAllCustomersResponseDto;
    }
}