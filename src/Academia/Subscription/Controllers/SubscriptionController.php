<?php

namespace Academia\Subscription\Controllers;

use Academia\Core\Controller\ControllerBase;
use Academia\Core\Controller\RequestController;
use Academia\Core\Validators\DateTimeValidator;
use Academia\Core\Validators\TextValidator;
use Academia\Subscription\Application\Services\Subscription\CancelSubscription\CancelSubscription;
use Academia\Subscription\Application\Services\Subscription\CancelSubscription\CancelSubscriptionRequestDto;
use Academia\Subscription\Application\Services\Subscription\GetSubscriptionById\GetSubscriptionById;
use Academia\Subscription\Application\Services\Subscription\CreateSubscription\CreateSubscription;
use Academia\Subscription\Application\Services\Subscription\CreateSubscription\CreateSubscriptionRequestDto;
use Academia\Subscription\Application\Services\Subscription\PaySubscription\PaySubscription;
use Academia\Subscription\Application\Services\Subscription\PaySubscription\PaySubscriptionRequestDto;
use Academia\Subscription\Infra\Repositories\RepositorySqlFactory;
use Academia\Subscription\Mappers\SubscriptionMap;

class SubscriptionController extends ControllerBase
{
    public static function createSubscription(RequestController $request): ?array
    {
        $body = $request->getBody();
        $subscriptionRepository = RepositorySqlFactory::getSubscriptionRepository();
        $subscriptionPlanRepository = RepositorySqlFactory::getSubscriptionPlanRepository();
        $serviceRepository = RepositorySqlFactory::getServiceRepository();
        $createSubscriptionRequestDto = new CreateSubscriptionRequestDto(
            $body['customer_id'],
            $body['customer_name'],
            $body['customer_cpf'],
            $body['subscription_plan_id'],
            $body['start_date'],
        );
        foreach ($body['services'] as $service) {
            $createSubscriptionRequestDto->addServiceId($service['id']);
        }
        $use_case = new CreateSubscription($subscriptionRepository, $subscriptionPlanRepository, $serviceRepository);
        $createSubscriptionResponseDto = $use_case->execute($createSubscriptionRequestDto); 
        return SubscriptionMap::toArray($createSubscriptionResponseDto->getSubscription());
    }

    public static function getById(RequestController $request): ?array
    {
        $subscriptionRepository = RepositorySqlFactory::getSubscriptionRepository();
        $use_case = new GetSubscriptionById($subscriptionRepository);
        $subscription = $use_case->execute($request->getParams()['id']);
        return SubscriptionMap::toArray($subscription);
    }

    public static function cancel(RequestController $request): ?array
    {
        $body = $request->getBody();
        DateTimeValidator::dateTimeIsValidOrException('Data de cancelamento', $body['canceling_date']);
        TextValidator::validateOrException('Motivo de cancelamento', $body['canceling_reason'], ['max' => 100, 'min' => 0, 'blank' => false]);
        $subscriptionRepository = RepositorySqlFactory::getSubscriptionRepository();
        $cancelSubscriptionRequestDto = new CancelSubscriptionRequestDto(
            $request->getParams()['id'],
            $body['canceling_date'],
            $body['canceling_reason']
        );
        $use_case = new CancelSubscription($subscriptionRepository);
        $cancelSubscriptionResponseDto = $use_case->execute($cancelSubscriptionRequestDto);
        return $cancelSubscriptionResponseDto->mapToArray();
    }

    public static function pay(RequestController $request): ?array
    {
        $body = $request->getBody();
        DateTimeValidator::dateTimeIsValidOrException('Data de cancelamento', $body['payment_date']);
        TextValidator::validateOrException('Motivo de cancelamento', $request->getParams()['id']);
        $subscriptionRepository = RepositorySqlFactory::getSubscriptionRepository();
        $paySubscriptionRequestDto = new PaySubscriptionRequestDto(
            $request->getParams()['id'],
            $body['payment_date']
        );
        $use_case = new PaySubscription($subscriptionRepository);
        $subscription = $use_case->execute($paySubscriptionRequestDto);
        return SubscriptionMap::toArray($subscription);
    }
}