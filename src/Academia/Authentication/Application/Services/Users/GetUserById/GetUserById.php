<?php

namespace Academia\Authentication\Application\Services\Users\GetUserById;

use Academia\Authentication\Domain\Entities\User;
use Academia\Authentication\Domain\Repositories\UserRepository;
use Academia\Core\Exceptions\NotFoundException;

class GetUserById
{
    private UserRepository $userRepository;

    public function __construct(
        UserRepository $userRepository
    )
    {
        $this->userRepository = $userRepository;
    }

    public function execute(string $id): ?User
    { 
        $user = $this->userRepository->getById($id);
        if (empty($user)) {
            throw new NotFoundException("Usuário não foi encontrado");
        }
        return $user;
    }
}