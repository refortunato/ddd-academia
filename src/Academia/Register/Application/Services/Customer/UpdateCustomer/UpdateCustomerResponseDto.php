<?php

namespace Academia\Register\Application\Services\Customer\UpdateCustomer;

use Academia\Register\Domain\Entities\Customer;

class UpdateCustomerResponseDto
{
    public ?Customer $customer;

    public function __construct(
        ?Customer $customer
    )
    {
        $this->customer = $customer;
    }

    public function getCustomer() : ?Customer
    {
        return $this->customer;
    }
}