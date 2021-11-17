<?php

namespace Academia\Core\Exceptions;

class NotFoundException extends \Exception
{
    public function __construct(string $message, int $code = 404)
    {
        parent::__construct($message, $code);
    }
}