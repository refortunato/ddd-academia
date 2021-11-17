<?php

namespace Academia\Authentication\Infra\Repositories;

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

    public static function getUserRepository(?DriverInterface $driver = null): UserRepositorySql
    {
        $driver = self::getDriver($driver);
        $userRepository = new UserRepositorySql($driver);
        return $userRepository;
    }
}