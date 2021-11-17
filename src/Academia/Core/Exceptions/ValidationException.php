<?php

namespace Academia\Core\Exceptions;

class ValidationException extends \Exception
{
    public function __construct(string $message, int $code = 400)
    {
        parent::__construct($message, $code);
    }
}