<?php

namespace Academia\Subscription\Controllers;

use Academia\Core\Controller\ControllerBase;
use Academia\Core\Controller\RequestController;
use Academia\Subscription\Application\Services\SubscriptionPlan\AddSubscriptionPlan\AddSubscriptionPlan;
use Academia\Subscription\Application\Services\SubscriptionPlan\AddSubscriptionPlan\AddSubscriptionPlanRequestDto;
use Academia\Subscription\Application\Services\SubscriptionPlan\AddSubscriptionPlan\AddSubscriptionPlanResponseDto;
use Academia\Subscription\Application\Services\SubscriptionPlan\GetAllSubscriptionPlan\GetAllSubscriptionPlan;
use Academia\Subscription\Application\Services\SubscriptionPlan\GetSubscriptionPlanById\GetSubscriptionPlanById;
use Academia\Subscription\Application\Services\SubscriptionPlan\RemoveSubscriptionPlan\RemoveSubscriptionPlan;
use Academia\Subscription\Application\Services\SubscriptionPlan\UpdateSubscriptionPlan\UpdateSubscriptionPlan;
use Academia\Subscription\Application\Services\SubscriptionPlan\UpdateSubscriptionPlan\UpdateSubscriptionPlanRequestDto;
use Academia\Subscription\Infra\Repositories\RepositorySqlFactory;
use Academia\Subscription\Mappers\SubscriptionPlanMap;

class SubscriptionPlanController extends ControllerBase
{
    public static function add(RequestController $request): ?array
    {
        $body = $request->getBody();
        $subscriptionPlanRepository = RepositorySqlFactory::getSubscriptionPlanRepository();
        $addSubscriptionPlanRequestDto = new AddSubscriptionPlanRequestDto(
            $body['name'],
            $body['total_plan_validity_months'],
            $body['discount_type'],
            $body['discount_value']
        );
        $use_case = new AddSubscriptionPlan($subscriptionPlanRepository);
        $addSubscriptionPlanResponseDto = $use_case->execute($addSubscriptionPlanRequestDto); 
        return SubscriptionPlanMap::toArray($addSubscriptionPlanResponseDto->getSubscriptionPlan());
    }

    public static function update(RequestController $request): ?array
    {
        $body = $request->getBody();
        $subscriptionPlanRepository = RepositorySqlFactory::getSubscriptionPlanRepository();
        $updateSubscriptionPlanRequestDto = new UpdateSubscriptionPlanRequestDto(
            $request->getParams()['id'],
            $body['name'],
            $body['total_plan_validity_months'],
            $body['discount_type'],
            $body['discount_value']
        );
        $use_case = new UpdateSubscriptionPlan($subscriptionPlanRepository);
        $updateSubscriptionPlanResponseDto = $use_case->execute($updateSubscriptionPlanRequestDto); 
        return SubscriptionPlanMap::toArray($updateSubscriptionPlanResponseDto->getSubscriptionPlan());
    }

    public static function delete(RequestController $request): ?array
    {
        $subscriptionPlanRepository = RepositorySqlFactory::getSubscriptionPlanRepository();
        $use_case = new RemoveSubscriptionPlan($subscriptionPlanRepository);
        $use_case->execute($request->getParams()['id']); 
        return [];
    }

    public static function getAll(RequestController $request): ?array
    {
        $subscriptionPlanRepository = RepositorySqlFactory::getSubscriptionPlanRepository();
        $use_case = new GetAllSubscriptionPlan($subscriptionPlanRepository);
        $getAllSubscriptionPlanResponseDto = $use_case->execute(); 
        $subscription_plan_array = [];
        foreach ($getAllSubscriptionPlanResponseDto->getSubscriptionPlans() as $subscription_plan) {
            $subscription_plan_array[] = SubscriptionPlanMap::toArray($subscription_plan);
        }
        return $subscription_plan_array;
    }

    public static function getById(RequestController $request): ?array
    {
        $subscriptionPlanRepository = RepositorySqlFactory::getSubscriptionPlanRepository();
        $use_case = new GetSubscriptionPlanById($subscriptionPlanRepository);
        $getSubscriptionPlanByIdResponseDto = $use_case->execute($request->getParams()['id']); 
        return SubscriptionPlanMap::toArray($getSubscriptionPlanByIdResponseDto->getSubscriptionPlan());
    }
}