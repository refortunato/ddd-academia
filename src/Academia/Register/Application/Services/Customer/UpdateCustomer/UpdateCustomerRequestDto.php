<?php

namespace Academia\Register\Application\Services\Customer\UpdateCustomer;

class UpdateCustomerRequestDto
{
    private string $id;
    private string $first_name;
    private string $last_name;
    private string $cpf;
    private string $birth_date;
    private string $status;
    private string $email;
    private string $subcription_plan_id;

    public function __construct(
        $id,
        $first_name,
        $last_name,
        $cpf,
        $birth_date,
        $status,
        $email,
        $subcription_plan_id
    )
    {
        $this->id = $id;
        $this->first_name = $first_name;
        $this->last_name = $last_name;
        $this->cpf = $cpf;
        $this->birth_date = $birth_date;
        $this->status = $status;
        $this->email = $email;
        $this->subcription_plan_id = $subcription_plan_id;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getFirstName()
    {
        return $this->first_name;
    }

    public function getLastName()
    {
        return $this->last_name;
    }

    public function getCpf()
    {
        return $this->cpf;
    }

    public function getBirthDate()
    {
        return $this->birth_date;
    }

    public function getStatus()
    {
        return $this->status;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function getSubcriptionPlanId()
    {
        return $this->subcription_plan_id;
    }
}