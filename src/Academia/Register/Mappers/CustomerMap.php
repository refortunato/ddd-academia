<?php

namespace Academia\Register\Mappers;

use Academia\Register\Domain\Entities\Customer;

class CustomerMap
{
    public static function toArray(Customer $customer): array
    {
        $array = [];
        $array['id'] = $customer->getId();
        $array['first_name'] = $customer->getName()->getFirstName();
        $array['last_name'] = $customer->getName()->getLastName();
        $array['cpf'] = (string) $customer->getCpf();
        $array['birth_date'] = !empty($customer->getBirthDate())? $customer->getBirthDate()->format('Y-m-d') : null;
        $array['status'] = $customer->getStatus();
        $array['email'] = (string) $customer->getEmail();
        $array['subscription_plan_id'] = $customer->getSubscriptionPlanId();

        return $array;
    }

    public static function toPersistance(Customer $customer): array
    {
        $array_map = [];
        $array_map['id'] = $customer->getId();
        $array_map['first_name'] = $customer->getName()->getFirstName();
        $array_map['last_name'] = $customer->getName()->getLastName();
        $array_map['birth_date'] = $customer->getBirthDate()->setTimezone(new \DateTimeZone("UTC"))->format('Y-m-d');
        $array_map['cpf'] = $customer->getCpf();
        $array_map['email'] = $customer->getEmail();
        $array_map['status'] = $customer->getStatus();
        $array_map['subscription_plan_id'] = $customer->getSubscriptionPlanId();

        return $array_map;
    }

    public static function toEntity(array $fields): ?Customer
    {
        return Customer::create(
            $fields['id'],
            $fields['first_name'],
            $fields['last_name'],
            $fields['cpf'],
            $fields['birth_date'],
            $fields['status'],
            $fields['email'],
            $fields['subscription_plan_id']
        );
    }
}