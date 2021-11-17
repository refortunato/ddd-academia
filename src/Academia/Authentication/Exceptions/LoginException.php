<?php

namespace Academia\Authentication\Exceptions;

class LoginException extends \Exception
{
    public function __construct(string $message, int $code = 401)
    {
        parent::__construct($message, $code);
    }
}