<?php

namespace Academia\Authentication\Domain\Entities;

use Academia\Authentication\Domain\Enum\UserLevel;
use Academia\Core\Entity;
use Academia\Core\ValueObjects\Email;

class User extends Entity
{
    private Email $email;
    private string $name;
    private string $user_level;
    private string $hashed_password;

    public function __construct(
        $id,
        Email $email,
        string $name,
        string $user_level,
        string $hashed_password
    )
    {
        parent::__construct($id);
        $this->name = $name;
        $this->email = $email;
        $this->user_level = $user_level;
        $this->hashed_password = $hashed_password;

        $this->validate();
    }

    public function getEmail(): Email
    {
        return $this->email;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getUserLevel(): string
    {
        return $this->user_level;
    }

    public function getHashedPassword(): string
    {
        return $this->hashed_password;
    }

    private function validate()
    {
        if (! in_array($this->user_level, UserLevel::getValues())  ) {
            throw new \DomainException("Nível de usuário é inválido.");
        }
        if (empty($this->hashed_password)) {
            throw new \DomainException("Senha do usuário não pode estar vazia.");
        }
    }
}