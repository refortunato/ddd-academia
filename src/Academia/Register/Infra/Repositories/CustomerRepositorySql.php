<?php

namespace Academia\Register\Infra\Repositories;

use Academia\Register\Domain\Repositories\CustomerRepository;
use Academia\Core\Entity;
use Academia\Core\Infra\DB\DataMapper\Repositories\Repository;
use Academia\Register\Domain\Entities\Customer;
use Academia\Register\Mappers\CustomerMap;

class CustomerRepositorySql extends Repository implements CustomerRepository
{
    protected ?string $table = 'customer';

    protected function makeEntity(array $fields): ?Entity
    {
        return CustomerMap::toEntity($fields);
    }

    protected function mapEntityToArrayFields(Entity $customer): array
    {
        return CustomerMap::toPersistance($customer);
    }

    public function getByCpf(string $cpf): array
    {
        $conditions = [];
        $conditions[] = ['cpf', $cpf];
        return $this->all($conditions);
    }

    public function save(Customer $customer): ?Customer
    {
        $exists = $this->first($customer->getId()) ? true : false;
        if ($exists) {
            $this->update($customer);
            return $customer;
        }
        $this->insert($customer);
        return $customer;
    }

    
    public function getById(string $id): ?Customer
    {
        return $this->first($id);
    }

    public function getAll(array $condition = []): array
    {
        return $this->all($condition);
    }


}