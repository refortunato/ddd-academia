<?php

namespace Academia\Register\Application\Services\Customer\GetCustomerById;

class GetCustomerByIdRequestDto
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