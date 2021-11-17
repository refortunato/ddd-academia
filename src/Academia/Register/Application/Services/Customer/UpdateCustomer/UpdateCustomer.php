<?php

namespace Academia\Register\Application\Services\Customer\UpdateCustomer;

use Academia\Core\Exceptions\InvalidCpfException;
use Academia\Core\Exceptions\NotFoundException;
use Academia\Register\Domain\Entities\Customer;
use Academia\Register\Domain\Repositories\CustomerRepository;

class UpdateCustomer
{
    private $customer_repository;

    public function __construct(CustomerRepository $customer_repository)
    {
        $this->customer_repository = $customer_repository;
    }

    public function execute(UpdateCustomerRequestDto $updateCustomerRequestDto): UpdateCustomerResponseDto
    {        
        try {
            $customer = $this->customer_repository->getById($updateCustomerRequestDto->getId());
            if (! $customer) {
                throw new NotFoundException("Cliente não foi encontrado para alteração.");
            }
            $customer = Customer::create(
                $customer->getId(),
                $updateCustomerRequestDto->getFirstName(),
                $updateCustomerRequestDto->getLastName(),
                $updateCustomerRequestDto->getCpf(),
                $updateCustomerRequestDto->getBirthDate(),
                $updateCustomerRequestDto->getStatus(),
                $updateCustomerRequestDto->getEmail(),
                $updateCustomerRequestDto->getSubcriptionPlanId(),
            );
            $customer_by_cpf = $this->customer_repository->getByCpf($customer->getCpf()->getCode());
            if (! empty($customer_by_cpf) && ($customer_by_cpf[0]->getId() != $customer->getId() || count($customer_by_cpf) > 1)) {
                throw new \DomainException("Já existe um cliente com o CPF cadastrado");
            }
            $updateCustomerResponseDto = new UpdateCustomerResponseDto($this->customer_repository->save($customer));
    
            return $updateCustomerResponseDto;
        } catch (InvalidCpfException $e) {
            throw new \DomainException($e->getMessage());
        }
    }
}