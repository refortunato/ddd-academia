<?php

namespace Academia\Core\Infra\DB\DataMapper\Drivers;

use Academia\Core\Infra\DB\DataMapper\QueryBuilder\QueryBuilderInterface;

interface DriverInterface
{
    public function connect($config);
    public function close();
    public function setQueryBuilder(QueryBuilderInterface $query);
    public function execute();
    public function executeSelectFromText(string $query, array $params = []);
    public function lastInsertedId();
    public function first();
    public function all();
    public function rowsAffected(): int;
}