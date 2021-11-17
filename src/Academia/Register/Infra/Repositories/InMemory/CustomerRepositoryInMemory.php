<?php

namespace Academia\Register\Infra\Repositories\InMemory;

use Academia\Register\Domain\Entities\Customer;
use Academia\Register\Domain\Enum\StatusCustomer;
use Academia\Register\Domain\Repositories\CustomerRepository;

class CustomerRepositoryInMemory implements CustomerRepository
{
    private $customers = [];

    public function getAll(): array
    {
        return $this->customers;
    }

    public function getById(string $id): ?Customer
    {
        foreach ($this->customers as $customer) {
            if ($customer->getId() == $id) {
                return $customer;
            }
        }
        return null;
    }

    public function getByCpf(string $cpf): array
    {
        $customers = [];
        foreach ($this->customers as $customer) {
            if ($customer->getCpf() == $cpf) {
                $customers[] = $customer;
            }
        }
        return $customers ;
    }

    public function save(Customer $customer): ?Customer
    {
        for ($i = 0; $i < count($this->customers); $i++) {
            if ($this->customers[$i]->getId() == $customer->getId()) {
                $this->customers[$i] = $customer;
                return $customer;
            }
        }
        $this->customers[] = $customer;
        return $customer;
    }

    public function delete(string $id): bool
    {
        for ($i = 0; $i < count($this->customers); $i++) {
            if ($this->customers[$i]->getId() == $id) {
                unset($this->customers[$i]);
                $this->customers = array_values($this->customers);
                return true;
            }
        }
        return false;
    }
}