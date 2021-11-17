<?php

namespace Academia\Register\Application\Services\Customer\GetCustomerById;

use Academia\Register\Domain\Entities\Customer;

class GetCustomerByIdResponseDto
{
    public ?Customer $customer;

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