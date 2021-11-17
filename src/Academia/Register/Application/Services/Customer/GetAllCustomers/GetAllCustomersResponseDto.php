<?php

namespace Academia\Register\Application\Services\Customer\GetAllCustomers;

use Academia\Register\Domain\Entities\Customer;

class GetAllCustomersResponseDto
{
    private $customers = [];

    public function addCustomer(Customer $customer)
    {
        $this->customers[] = $customer;
    }

    public function getCustomers()
    {
        return $this->customers;
    }
}