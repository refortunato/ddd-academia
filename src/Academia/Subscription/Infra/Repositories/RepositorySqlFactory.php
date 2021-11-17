<?php

namespace Academia\Subscription\Infra\Repositories;

use Academia\Core\Infra\DB\DataMapper\Drivers\DriverFactory;
use Academia\Core\Infra\DB\DataMapper\Drivers\DriverInterface;
use Academia\Subscription\Infra\Repositories\ServiceRepositorySql;
use Academia\Subscription\Infra\Repositories\SubscriptionRepositorySql;
use Academia\Subscription\Infra\Repositories\SubscriptionServiceRepositorySql;
use Academia\Subscription\Infra\Repositories\SubscritionPlanRepositorySql;

class RepositorySqlFactory
{
    private static function getDriver(?DriverInterface $driver = null): DriverInterface
    {
        if (empty($driver)) {
            $driver = DriverFactory::makeSqlDriver();
        }
        return $driver;
    }

    public static function getServiceRepository(?DriverInterface $driver = null): ServiceRepositorySql
    {
        $driver = self::getDriver($driver);
        $repository = new ServiceRepositorySql($driver);
        return $repository;
    }

    public static function getSubscriptionRepository(?DriverInterface $driver = null): SubscriptionRepositorySql
    {
        $driver = self::getDriver($driver);
        $repository = new SubscriptionRepositorySql($driver);
        return $repository;
    }

    public static function getSubscriptionServiceRepository(?DriverInterface $driver = null): SubscriptionServiceRepositorySql
    {
        $driver = self::getDriver($driver);
        $repository = new SubscriptionServiceRepositorySql($driver);
        return $repository;
    }

    public static function getSubscriptionPlanRepository(?DriverInterface $driver = null): SubscriptionPlanRepositorySql
    {
        $driver = self::getDriver($driver);
        $repository = new SubscriptionPlanRepositorySql($driver);
        return $repository;
    }
}