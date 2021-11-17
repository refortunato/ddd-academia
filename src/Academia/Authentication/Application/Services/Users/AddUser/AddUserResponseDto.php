<?php

namespace Academia\Authentication\Application\Services\Users\AddUser;

use Academia\Authentication\Domain\Entities\User;

class AddUserResponseDto
{
    private User $user;

    public function __construct(
        User $user
    )
    {
        $this->user = $user;
    }

    public function getUser(): User
    {
        return $this->user;
    }
}