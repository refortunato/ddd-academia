<?php

namespace Academia\Authentication\Application\Services\Users\IsAuthorized;

use Academia\Authentication\Domain\Protocols\Jwt;

class IsAuthorized
{
    private Jwt $jwt;

    public function __construct(Jwt $jwt)
    {
        $this->jwt = $jwt;
    }

    public function execute(string $token): bool
    {
        $this->jwt->decrypt($token);
        return true;
    }
}