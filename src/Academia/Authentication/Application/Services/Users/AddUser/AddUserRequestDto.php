<?php

namespace Academia\Authentication\Application\Services\Users\AddUser;

class AddUserRequestDto
{
    private string $email;
    private string $name;
    private string $password;
    private string $password_confirmation;
    private string $user_level;

    public function __construct(
        string $email,
        string $name,
        string $password,
        string $password_confirmation
    )
    {
        $this->email = $email;
        $this->name = $name;
        $this->password = $password;
        $this->password_confirmation = $password_confirmation;
        $this->user_level = '';
    }

    /**
     * Getters
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function getPasswordConfirmation(): string
    {
        return $this->password_confirmation;
    }
}

