<?php

namespace Academia\Register\Infra\Repositories;

use Academia\Core\Infra\DB\DataMapper\Drivers\DriverFactory;
use Academia\Core\Infra\DB\DataMapper\Drivers\DriverInterface;

class RepositorySqlFactory
{
    private static function getDriver(?DriverInterface $driver = null): DriverInterface
    {
        if (empty($driver)) {
            $driver = DriverFactory::makeSqlDriver();
        }
        return $driver;
    }

    public static function getCustomerRepository(?DriverInterface $driver = null): CustomerRepositorySql
    {
        $driver = self::getDriver($driver);
        $userRepository = new CustomerRepositorySql($driver);
        return $userRepository;
    }
}