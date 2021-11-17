<?php

use Academia\Authentication\Infra\Criptography\PasswordHasherAdapter;
use Academia\Authentication\Infra\Repositories\InMemory\UserRepositoryInMemory;
use Academia\Authentication\Application\Services\Users\AddUser\AddUser;
use Academia\Authentication\Application\Services\Users\AddUser\AddUserRequestDto;
use PHPUnit\Framework\TestCase;

class AddUserTest extends TestCase
{
    public function testShouldBeOk()
    {
        $userRepository = new UserRepositoryInMemory();
        $password_hasher = new PasswordHasherAdapter();
        $addUserRequestDto = new AddUserRequestDto(
            'any_mail@mail.com',
            'any_name',
            'any_password',
            'any_password',
        );
        $use_case = new AddUser($userRepository, $password_hasher);
        $addUserResponseDto = $use_case->execute($addUserRequestDto);
        self::assertNotEmpty($addUserResponseDto->getUser());
    }

    public function testPasswordConfirmationShouldFail()
    {
        $this->expectException("DomainException");
        $this->expectExceptionMessage("Senha e confirmação de senha não coincidem");

        $userRepository = new UserRepositoryInMemory();
        $password_hasher = new PasswordHasherAdapter();
        $addUserRequestDto = new AddUserRequestDto(
            'any_mail@mail.com',
            'any_name',
            'any_password',
            'any_password_diff',
        );
        $use_case = new AddUser($userRepository, $password_hasher);
        $addUserResponseDto = $use_case->execute($addUserRequestDto);
    }
}