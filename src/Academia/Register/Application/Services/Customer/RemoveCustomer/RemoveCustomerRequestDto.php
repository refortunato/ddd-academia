<?php

namespace Academia\Register\Application\Services\Customer\RemoveCustomer;

class RemoveCustomerRequestDto
{
    private string $id;

    public function __construct(
        $id
    )
    {
        $this->id = $id;
    }

    public function getId()
    {
        return $this->id;
    }
}