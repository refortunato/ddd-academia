<?php

namespace Academia\Authentication\Application\Services\Users\Login;

class LoginRequestDto
{
    private string $email;
    private string $password;

    public function __construct(
        string $email,
        string $password
    )
    {
        $this->email = $email;
        $this->password = $password;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getPassword(): string
    {
        return $this->password;
    }
}