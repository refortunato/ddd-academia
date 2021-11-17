<?php

namespace Academia\Authentication\Application\Services\Users\AddUser;

use Academia\Authentication\Domain\Entities\User;
use Academia\Authentication\Domain\Enum\UserLevel;
use Academia\Authentication\Domain\Protocols\PasswordHasher;
use Academia\Authentication\Domain\Repositories\UserRepository;
use Academia\Core\ValueObjects\Email;

class AddUser
{
    private UserRepository $userRepository;
    private PasswordHasher $passwordHasher;

    public function __construct(
        UserRepository $userRepository,
        PasswordHasher $passwordHasher
    )
    {
        $this->userRepository = $userRepository;
        $this->passwordHasher = $passwordHasher;
    }

    public function execute(AddUserRequestDto $addUserRequestDto): AddUserResponseDto
    {
        if (empty($addUserRequestDto->getPassword())) {
            throw new \DomainException("Senha do usuário não pode estar em branco.");
        }
        if (strlen($addUserRequestDto->getPassword()) < 8) {
            throw new \DomainException("Senha deve possuir pelo menos 8 caracteres.");
        }
        if ($addUserRequestDto->getPassword() != $addUserRequestDto->getPasswordConfirmation()) {
            throw new \DomainException("Senha e confirmação de senha não coincidem");
        }
        $user = $this->userRepository->getByEmail($addUserRequestDto->getEmail());
        if (! empty($user)) {
            throw new \DomainException("Este e-mail já foi utilizado.");
        }
        $user = new User(
            '',
            new Email($addUserRequestDto->getEmail()),
            $addUserRequestDto->getName(),
            UserLevel::COMMON,
            $this->passwordHasher->hash($addUserRequestDto->getPassword())
        );
        $this->userRepository->save($user);
        return new AddUserResponseDto($user);
    }
}