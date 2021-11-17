<?php

use Academia\Authentication\Application\Services\Users\Login\Login;
use Academia\Authentication\Application\Services\Users\Login\LoginRequestDto;
use Academia\Authentication\Domain\Entities\User;
use Academia\Authentication\Domain\Enum\UserLevel;
use Academia\Authentication\Domain\Protocols\Jwt;
use Academia\Authentication\Domain\Protocols\PasswordHasher;
use Academia\Authentication\Domain\Repositories\UserRepository;
use Academia\Authentication\Infra\Criptography\JwtAdapter;
use Academia\Authentication\Infra\Criptography\PasswordHasherAdapter;
use Academia\Authentication\Infra\Repositories\InMemory\UserRepositoryInMemory;
use Academia\Core\ValueObjects\Email;
use PHPUnit\Framework\TestCase;

class LoginTest extends TestCase
{
    private $user_id = '6c8a4ea4-b525-46b8-9f09-191bb896306c';

    private function makeJwt(): Jwt
    {
        return new JwtAdapter();
    }

    private function makePasswordHasher(): PasswordHasher
    {
        return new PasswordHasherAdapter();
    }

    private function makeUserRepositoryWithData(): UserRepository
    {
        $password_hasher = $this->makePasswordHasher();
        $user = new User(
            $this->user_id,
            new Email('any@mail.com'),
            'Any Name',
            UserLevel::ADMIN,
            $password_hasher->hash('any_password')
        );
        $userRepository = new UserRepositoryInMemory();
        $userRepository->save($user);
        return $userRepository;
    }

    public function testShouldBeOk()
    {
        $userRepository = $this->makeUserRepositoryWithData();
        $password_hasher = $this->makePasswordHasher();
        $jwt = $this->makeJwt();
        $use_case = new Login($userRepository, $password_hasher, $jwt);
        $login_request_dto = new LoginRequestDto(
            'any@mail.com',
            'any_password'
        );
        $login_response_dto = $use_case->execute($login_request_dto);
        self::assertNotEmpty($login_response_dto->getToken());
        self::assertEquals($jwt->decrypt($login_response_dto->getToken())->id, $this->user_id);
    }
}