<?php

use Academia\Authentication\Application\Services\Users\IsAuthorized\IsAuthorized;
use Academia\Authentication\Domain\Protocols\Jwt;
use Academia\Authentication\Infra\Criptography\JwtAdapter;
use PHPUnit\Framework\TestCase;

class IsAuthorizedTest extends TestCase
{
    private function makeJwt(): Jwt
    {
        return new JwtAdapter();
    }

    public function testShouldBeOk()
    {
        $jwt = $this->makeJwt();
        $use_case = new IsAuthorized($jwt);
        $token = $jwt->encrypt(['id' => '123456', 'name' => 'Any Name']);
        $result = $use_case->execute($token);
        self::assertTrue($result);
    }

    public function testShouldThrowWhenTokenIsInvalid()
    {
        $this->expectExceptionMessage("Signature verification failed"); 
        $this->expectException("Academia\Authentication\Exceptions\LoginException");

        $jwt = $this->makeJwt();
        $use_case = new IsAuthorized($jwt);
        $token = $jwt->encrypt(['id' => '123456', 'name' => 'Any Name']);
        $token = substr($token, 0, strlen($token) - 1);
        $result = $use_case->execute($token);
        self::assertTrue($result);
    }

    public function testShouldThrowWhenTokenIsExpired()
    {
        $this->expectExceptionMessage("Expired token"); 
        $this->expectException("Academia\Authentication\Exceptions\LoginException");

        $today = new \DateTime('now', new \DateTimeZone("UTC"));
        $today->sub(\DateInterval::createFromDateString('1 second'));

        $jwt = $this->makeJwt();
        $use_case = new IsAuthorized($jwt);
        $token = $jwt->encrypt(['id' => '123456', 'name' => 'Any Name', 'exp'=>$today->getTimestamp()]);
        $result = $use_case->execute($token);
        self::assertTrue($result);
    }
}