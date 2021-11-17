<?php

namespace Academia\Register\Application\Services\Customer\RemoveCustomer;

use Academia\Core\Exceptions\NotFoundException;
use Academia\Register\Domain\Repositories\CustomerRepository;

class RemoveCustomer
{
    private $customer_repository;

    public function __construct(CustomerRepository $customer_repository)
    {
        $this->customer_repository = $customer_repository;
    }

    public function execute(RemoveCustomerRequestDto $removeCustomerRequestDto): bool
    {
        $customer = $this->customer_repository->getById($removeCustomerRequestDto->getId());
        if (! $customer) {
            throw new NotFoundException("Cliente não foi encontrado para remover.");
        }
        return $this->customer_repository->delete($customer->getId());
    }
}