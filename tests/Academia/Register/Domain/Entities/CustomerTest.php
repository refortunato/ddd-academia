<?php

// Rodar no terminal
//cd vendor/bin

//Para executar todos
//php vendor/bin/phpunit -c ../../phpunit.xml

//Para executar apenas um suite
//php vendor/bin/phpunit -c ../../phpunit.xml --testesuite nome_do_suite
//Exemplo: php vendor/bin/phpunit -c phpunit.xml --testsuite unit

use Academia\Register\Domain\Entities\Customer;
use Academia\Register\Domain\Enum\StatusCustomer;
use PHPUnit\Framework\TestCase;

final class CustomerTest extends TestCase
{
    public function testCreateCustomer()
    {
        $customer = Customer::create(
            '',
            'customer_name',
            'any_last_name',
            '755.716.950-64',
            '2000-01-01',
            StatusCustomer::ACTIVE,
            'any_mail@mail.com',
            ''
        );

        self::assertNotEmpty($customer);
        self::assertInstanceOf(
            Customer::class,
            $customer 
        );
    }

    public function testShoulFailInvalidEmail()
    {
        $this->expectException("DomainException");
        $this->expectExceptionMessage("E-mail inválido");

        $customer = Customer::create(
            '',
            'customer_name',
            'any_last_name',
            '75571695064',
            '2000-01-01',
            StatusCustomer::ACTIVE,
            'any_mail1.com',
            ''
        );
    }

    public function testShoulFailInvalidCpf()
    {
        $this->expectExceptionMessage("CPF 123.456.789-99 é inválido"); 
        $this->expectException("Academia\Core\Exceptions\InvalidCpfException");

        $customer = Customer::create(
            '',
            'customer_name',
            'any_last_name',
            '123.456.789-99',
            '2000-01-01',
            StatusCustomer::ACTIVE,
            'any_mail@mail.com',
            ''
        );
    }
}