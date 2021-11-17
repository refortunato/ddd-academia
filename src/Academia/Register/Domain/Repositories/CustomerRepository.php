<?php

namespace Academia\Register\Domain\Repositories;

use Academia\Register\Domain\Entities\Customer;

interface CustomerRepository
{
    public function getAll(): array;
    public function getById(string $id): ?Customer;
    public function getByCpf(string $cpf): array;
    public function save(Customer $customer): ?Customer;
    public function delete(string $id): bool;
}