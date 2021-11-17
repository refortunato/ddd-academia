<?php

use Academia\Authentication\Controllers\UserController;
use Academia\Core\Controller\RequestController;
use Academia\Core\Helpers\HttpStatus;
use PHPUnit\Framework\TestCase;

class UserControllerTest extends TestCase
{
    public function testLoginShouldBeOk()
    {
        $requestController = new RequestController(
            [], //args (params)
            [], // QueryParams
            ['email' => 'any_mail@mail.com', 'password' => 'any_password_123'],//body
            [] // headers
        );
        $result = UserController::execute('login', $requestController);
        //$result = call_user_func_array(UserController::class.'::execute',['login', $requestController]);
        $this->assertEquals(HttpStatus::OK, $result->getHttpStatus());
        $this->assertNotEmpty($result->getData()['token']);
    }

    public function testLoginShouldFail()
    {
        $requestController = new RequestController(
            [], //args (params)
            [], // QueryParams
            ['email' => 'any_mail@mail.com', 'password' => ''],//body
            [] // headers
        );
        $result = UserController::execute('login', $requestController);
        //$result = call_user_func_array(UserController::class.'::execute',['login', $requestController]);
        $data = $result->getData();
        $this->assertEquals(HttpStatus::UNAUTHORIZED, $result->getHttpStatus());
        $this->assertNotEmpty($data['message']);
        $this->assertEquals($data['message'], 'Login e ou Senha inválidos.');
    }
}