<?php

namespace Academia\Authentication\Application\Services\Users\Login;

class LoginResponseDto
{
    private string $token;

    public function __construct(string $token)
    {
        $this->token = $token;
    }

    public function getToken(): string
    {
        return $this->token;
    }

    public function mapToArray(): array
    {
        return [
            'token' => $this->getToken()
        ];
    }
}