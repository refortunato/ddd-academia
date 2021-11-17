<?php

namespace Academia\Core\Infra\DB\DataMapper\QueryBuilder;

interface QueryBuilderInterface
{
    public function getValues();
    public function __toString();
}