<?php

namespace Academia\Authentication\Application\Services\Users\Login;

use Academia\Authentication\Domain\Protocols\Jwt;
use Academia\Authentication\Domain\Protocols\PasswordHasher;
use Academia\Authentication\Domain\Repositories\UserRepository;
use Academia\Authentication\Exceptions\LoginException;

class Login
{
    private UserRepository $userRepository;
    private PasswordHasher $passwordHasher;
    private Jwt $jwt;

    public function __construct(
        UserRepository $userRepository,
        PasswordHasher $passwordHasher,
        Jwt $jwt
    )
    {
        $this->userRepository = $userRepository;
        $this->passwordHasher = $passwordHasher;
        $this->jwt = $jwt;
    }

    public function execute(LoginRequestDto $loginRequestDto): LoginResponseDto
    {
        $users = $this->userRepository->getByEmail($loginRequestDto->getEmail());
        if (empty($users)) {
            throw new LoginException("Login e ou Senha inválidos.");
        }
        if (count($users) > 1) {
            throw new \Exception("Possui mais de um usuário com o mesmo e-mail");
        }
        if (! $this->passwordHasher->verify($loginRequestDto->getPassword(), $users[0]->getHashedPassword())) {
            throw new LoginException("Login e ou Senha inválidos.");
        }
        $token = $this->jwt->encrypt(
            [
                'id' => $users[0]->getId(),
                'user_level' => $users[0]->getUserLevel()
            ]
        );
        return new LoginResponseDto($token);
    }
}