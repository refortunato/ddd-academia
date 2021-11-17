<?php

namespace Academia\Authentication\Domain\Protocols;

interface Jwt
{
    public function encrypt(array $payload_data): string;
    public function decrypt(string $jwt);
}