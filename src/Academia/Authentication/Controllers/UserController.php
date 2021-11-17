<?php

namespace Academia\Authentication\Controllers;

use Academia\Authentication\Application\Services\Users\AddUser\AddUser;
use Academia\Authentication\Application\Services\Users\AddUser\AddUserRequestDto;
use Academia\Authentication\Application\Services\Users\GetUserById\GetUserById;
use Academia\Authentication\Application\Services\Users\IsAuthorized\IsAuthorized;
use Academia\Authentication\Application\Services\Users\Login\Login;
use Academia\Authentication\Application\Services\Users\Login\LoginRequestDto;
use Academia\Authentication\Exceptions\LoginException;
use Academia\Authentication\Infra\Criptography\JwtAdapter;
use Academia\Authentication\Infra\Criptography\PasswordHasherAdapter;
use Academia\Authentication\Infra\Repositories\RepositorySqlFactory;
use Academia\Authentication\Mappers\UserMap;
use Academia\Core\Controller\ControllerBase;
use Academia\Core\Controller\RequestController;

class UserController extends ControllerBase
{
    protected static function addUser(RequestController $request): ?array
    {
        $body = $request->getBody();
        $userRepository = RepositorySqlFactory::getUserRepository();
        $password_hasher = new PasswordHasherAdapter();
        $addUserRequestDto = new AddUserRequestDto(
            $body['email'],
            $body['name'],
            $body['password'],
            $body['password_confirmation']
        );
        $use_case = new AddUser($userRepository, $password_hasher);
        $addUserResponseDto = $use_case->execute($addUserRequestDto);
        return UserMap::toArray($addUserResponseDto->getUser());
    }

    protected static function getById(RequestController $request): ?array
    {
        $params = $request->getParams();
        $userRepository = RepositorySqlFactory::getUserRepository();
        $use_case = new GetUserById($userRepository);
        $result = $use_case->execute($params['id']);
        return UserMap::toArray($result);
    }

    protected static function login(RequestController $request): ?array
    {
        $body = $request->getBody();
        $userRepository = RepositorySqlFactory::getUserRepository();
        $password_hasher = new PasswordHasherAdapter();
        $jwt = new JwtAdapter();
        $use_case = new Login($userRepository, $password_hasher, $jwt);
        $login_request_dto = new LoginRequestDto(
            $body['email'],
            $body['password']
        );
        $loginResponseDto = $use_case->execute($login_request_dto);
        return $loginResponseDto->mapToArray();
    }

    protected static function isAuthorized(RequestController $request): ?array
    {
        $headers = $request->getHeaders();
        $headers = array_change_key_case($headers, CASE_UPPER);
        if (! isset($headers['AUTHORIZATION'])) {
            throw new LoginException("Token Ausente.");
        }
        $token = $headers['AUTHORIZATION'];
        if (is_array($token)) {
            $token = $token[0];
        }
        $token = str_ireplace('Bearer ', '', $token);
        $jwt = new JwtAdapter();
        $use_case = new IsAuthorized($jwt);
        $is_authorized = $use_case->execute($token);
        if (! $is_authorized) {
            throw new LoginException("Token is not autorized");
        }
        return ['message' => 'Token is Authorized'];
    }
}