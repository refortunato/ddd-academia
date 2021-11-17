<?php

namespace Academia\Register\Domain\ValueObjects;

class Name 
{
    private string $first_name;
    private string $last_name;

    public function __construct(string $first_name, string $last_name)
    {
        $this->first_name = ucwords($first_name);
        $this->last_name = ucwords($last_name);

        $this->validate();
    }

    public function __toString()
    {
        return $this->first_name.' '.$this->last_name;
    }

    public function getFirstName() : string
    {
        return $this->first_name;
    }

    public function getLastName(): string
    {
        return $this->last_name;
    }

    private function validate(): void
    {
        if (strlen($this->first_name) < 2) {
            throw new \DomainException("Nome deve ter no mínimo 2 caracteres");
        }

        if (strlen($this->last_name) < 2) {
            throw new \DomainException("Sobrenome deve ter no mínimo 2 caracteres");
        }
    }
}