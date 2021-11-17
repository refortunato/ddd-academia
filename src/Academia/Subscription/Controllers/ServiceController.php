<?php

namespace Academia\Subscription\Controllers;

use Academia\Core\Controller\ControllerBase;
use Academia\Core\Controller\RequestController;
use Academia\Subscription\Application\Services\Service\AddService\AddService;
use Academia\Subscription\Application\Services\Service\AddService\AddServiceRequestDto;
use Academia\Subscription\Application\Services\Service\GetAllServices\GetAllServices;
use Academia\Subscription\Application\Services\Service\GetServiceById\GetServiceById;
use Academia\Subscription\Application\Services\Service\RemoveService\RemoveService;
use Academia\Subscription\Application\Services\Service\UpdateService\UpdateService;
use Academia\Subscription\Application\Services\Service\UpdateService\UpdateServiceRequestDto;
use Academia\Subscription\Infra\Repositories\RepositorySqlFactory;
use Academia\Subscription\Mappers\ServiceMap;

class ServiceController extends ControllerBase
{
    public static function add(RequestController $request): ?array
    {
        $body = $request->getBody();
        $serviceRepository = RepositorySqlFactory::getServiceRepository();
        $addServiceRequestDto = new AddServiceRequestDto(
            $body['name'],
            $body['price'],
            $body['status']
        );
        $use_case = new AddService($serviceRepository);
        $addServiceResponseDto = $use_case->execute($addServiceRequestDto); 
        return ServiceMap::toArray($addServiceResponseDto->getService());
    }

    public static function update(RequestController $request): ?array
    {
        $body = $request->getBody();
        $serviceRepository = RepositorySqlFactory::getServiceRepository();
        $updateServiceRequestDto = new UpdateServiceRequestDto(
            $request->getParams()['id'],
            $body['name'],
            $body['price'],
            $body['status']
        );
        $use_case = new UpdateService($serviceRepository);
        $updateServiceResponseDto = $use_case->execute($updateServiceRequestDto); 
        return ServiceMap::toArray($updateServiceResponseDto->getService());
    }

    public static function delete(RequestController $request): ?array
    {
        $serviceRepository = RepositorySqlFactory::getServiceRepository();
        $use_case = new RemoveService($serviceRepository);
        $use_case->execute($request->getParams()['id']); 
        return [];
    }

    public static function getAll(RequestController $request): ?array
    {
        $serviceRepository = RepositorySqlFactory::getServiceRepository();
        $use_case = new GetAllServices($serviceRepository);
        $getAllServicesResponseDto = $use_case->execute(); 
        $services_array = [];
        foreach ($getAllServicesResponseDto->getServices() as $service) {
            $services_array[] = ServiceMap::toArray($service);
        }
        return $services_array;
    }

    public static function getById(RequestController $request): ?array
    {
        $serviceRepository = RepositorySqlFactory::getServiceRepository();
        $use_case = new GetServiceById($serviceRepository);
        $getServiceByIdResponseDto = $use_case->execute($request->getParams()['id']); 
        return ServiceMap::toArray($getServiceByIdResponseDto->getService());
    }
}