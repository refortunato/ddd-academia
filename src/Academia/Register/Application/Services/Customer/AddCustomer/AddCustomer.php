<?php

namespace Academia\Register\Application\Services\Customer\AddCustomer;

use Academia\Core\Exceptions\InvalidCpfException;
use Academia\Register\Domain\Entities\Customer;
use Academia\Register\Domain\Repositories\CustomerRepository;

class AddCustomer
{
    private $customer_repository;

    public function __construct(CustomerRepository $customer_repository)
    {
        $this->customer_repository = $customer_repository;
    }

    public function execute(AddCustomerRequestDto $addCustomerRequestDto): AddCustomerResponseDto
    {        
        try {
            $customer = Customer::create(
                '',
                $addCustomerRequestDto->getFirstName(),
                $addCustomerRequestDto->getLastName(),
                $addCustomerRequestDto->getCpf(),
                $addCustomerRequestDto->getBirthDate(),
                $addCustomerRequestDto->getStatus(),
                $addCustomerRequestDto->getEmail(),
                $addCustomerRequestDto->getSubcriptionPlanId(),
            );
            if (! empty($this->customer_repository->getByCpf($customer->getCpf()->getCode()))) {
                throw new \DomainException("Já existe um cliente com o CPF cadastrado");
            }
            $addCustomerRequestDto = new AddCustomerResponseDto($this->customer_repository->save($customer));
            return $addCustomerRequestDto;
        } catch (InvalidCpfException $e) {
            throw new \DomainException($e->getMessage());
        }

        
    }
}