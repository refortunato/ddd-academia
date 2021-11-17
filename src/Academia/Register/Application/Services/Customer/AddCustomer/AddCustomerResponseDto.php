<?php

namespace Academia\Register\Application\Services\Customer\AddCustomer;

use Academia\Register\Domain\Entities\Customer;

class AddCustomerResponseDto
{
    private ?Customer $customer;

    public function __construct(
        ?Customer $customer
    )
    {
        $this->customer = $customer;
    }

    public function getCustomer(): ?Customer
    {
        return $this->customer;
    }
}