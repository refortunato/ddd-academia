<?php

namespace Academia\Authentication\Domain\Protocols;

interface PasswordHasher
{
    public function hash(string $password): string;
    public function verify(string $password, string $hashed_password): bool;

}