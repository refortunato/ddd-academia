<?php

namespace Academia\Register\Domain\Entities;

use Academia\Register\Domain\ValueObjects\Cpf;
use Academia\Core\Entity;
use Academia\Core\Helpers\DateTime;
use Academia\Core\ValueObjects\Email;
use Academia\Register\Domain\Enum\StatusCustomer;
use Academia\Register\Domain\ValueObjects\Name;

class Customer extends Entity
{
    private Name $name;
    private Cpf $cpf;
    private \DateTime $birth_date;
    private string $status;
    private Email $email;
    private string $subscription_plan_id;

    public static function create(
        string $id,
        string $first_name,
        string $last_name,
        string $cpf,
        string $birth_date,
        string $status,
        string $email,
        string $subscription_plan_id
    ): Customer
    {
        $_name = new Name($first_name, $last_name);
        $_cpf = new Cpf($cpf);
        try {
            $_birth_date = DateTime::createDateTimeObjFromDateString($birth_date);
            $_birth_date->setTime(0,0,0);
        } catch(\Exception $e) {
            throw new \InvalidArgumentException("Data de nascimento é inválida.");
        }
        
        $_status = $status;
        $_email = new Email($email);
        $_subscription_plan_id = $subscription_plan_id;

        return new static(
            $id,
            $_name,
            $_cpf,
            $_birth_date,
            $_status,
            $_email,
            $_subscription_plan_id
        );
    }
     
    private function __construct(
        string $id, 
        Name $name, 
        Cpf $cpf,
        \DateTime $birth_date, 
        string $status, 
        Email $email,
        string $subscription_plan_id)
    {
        
        parent::__construct($id);
        $this->name = $name;
        $this->cpf = $cpf;
        $this->birth_date = $birth_date;
        $this->status = $status;
        $this->email = $email;
        $this->subscription_plan_id = $subscription_plan_id;

        $this->validate();
    }

    public function getName(): Name
    {
        return $this->name;
    }

    public function getCpf(): Cpf
    {
        return $this->cpf;
    }

    public function getBirthDate(): \DateTime
    {
        return $this->birth_date;
    }

    public function getStatus(): string
    {
        return $this->status;
    }

    public function getEmail(): Email
    {
        return $this->email;
    }

    public function getSubscriptionPlanId(): string
    {
        return $this->subscription_plan_id;
    }

    private function validate()
    {
        if (! in_array($this->status, StatusCustomer::getValues())  ) {
            throw new \DomainException("Status do cliente é inválido.");
        }
    }
}