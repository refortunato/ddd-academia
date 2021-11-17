<?php

namespace Academia\Register\Controllers;

use Academia\Core\Controller\ControllerBase;
use Academia\Core\Controller\RequestController;
use Academia\Register\Application\Services\Customer\AddCustomer\AddCustomer;
use Academia\Register\Application\Services\Customer\AddCustomer\AddCustomerRequestDto;
use Academia\Register\Application\Services\Customer\GetAllCustomers\GetAllCustomers;
use Academia\Register\Application\Services\Customer\GetCustomerById\GetCustomerById;
use Academia\Register\Application\Services\Customer\GetCustomerById\GetCustomerByIdRequestDto;
use Academia\Register\Application\Services\Customer\RemoveCustomer\RemoveCustomer;
use Academia\Register\Application\Services\Customer\RemoveCustomer\RemoveCustomerRequestDto;
use Academia\Register\Application\Services\Customer\UpdateCustomer\UpdateCustomer;
use Academia\Register\Application\Services\Customer\UpdateCustomer\UpdateCustomerRequestDto;
use Academia\Register\Infra\Repositories\RepositorySqlFactory;
use Academia\Register\Mappers\CustomerMap;

class CustomerController extends ControllerBase
{
    protected static function add(RequestController $request): ?array
    {
        $body = $request->getBody();
        $customerRepository = RepositorySqlFactory::getCustomerRepository();
        $addCustomerRequestDto = new AddCustomerRequestDto(
            $body['first_name'],
            $body['last_name'],
            $body['cpf'],
            $body['birth_date'],
            $body['status'],
            $body['email'],
            $body['subscription_plan_id'],
        );
        $use_case = new AddCustomer($customerRepository);
        $customerResponseDto = $use_case->execute($addCustomerRequestDto); 
        return CustomerMap::toArray($customerResponseDto->getCustomer());
    }

    protected static function update(RequestController $request): ?array
    {
        $body = $request->getBody();
        $customerRepository = RepositorySqlFactory::getCustomerRepository();
        $updateCustomerRequestDto = new UpdateCustomerRequestDto(
            $request->getParams()['id'],
            $body['first_name'],
            $body['last_name'],
            $body['cpf'],
            $body['birth_date'],
            $body['status'],
            $body['email'],
            $body['subscription_plan_id'],
        );
        $use_case = new UpdateCustomer($customerRepository);
        $updateCustomerResponseDto = $use_case->execute($updateCustomerRequestDto); 
        return CustomerMap::toArray($updateCustomerResponseDto->getCustomer());
    }

    protected static function getAll(RequestController $request): ?array
    {
        $customerRepository = RepositorySqlFactory::getCustomerRepository();
        $use_case = new GetAllCustomers($customerRepository);
        $getAllCustomerResponseDto = $use_case->execute(); 
        $customers_array = [];
        foreach ($getAllCustomerResponseDto->getCustomers() as $customer) {
            $customers_array[] = CustomerMap::toArray($customer);
        }
        return $customers_array;
    }

    protected static function delete(RequestController $request): ?array
    {
        $customerRepository = RepositorySqlFactory::getCustomerRepository();
        $removeCustomerRequestDto = new RemoveCustomerRequestDto($request->getParams()['id']);
        $use_case = new RemoveCustomer($customerRepository);
        $use_case->execute($removeCustomerRequestDto); 
        return [];
    }

    protected static function getById(RequestController $request): ?array
    {
        $customerRepository = RepositorySqlFactory::getCustomerRepository();
        $getCustomerByIdRequestDto = new GetCustomerByIdRequestDto($request->getParams()['id']);
        $use_case = new GetCustomerById($customerRepository);
        $getCustomerByIdResponseDto = $use_case->execute($getCustomerByIdRequestDto); 
        return CustomerMap::toArray($getCustomerByIdResponseDto->getCustomer());
    }
}