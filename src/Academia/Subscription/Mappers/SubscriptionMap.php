<?php

namespace Academia\Subscription\Mappers;

use Academia\Core\Helpers\DateTime;
use Academia\Subscription\Domain\Entities\Subscription;
use Academia\Subscription\Domain\Entities\SubscriptionPlan;
use Academia\Subscription\Domain\Entities\SubscriptionService;

class SubscriptionMap
{
    public static function toArray(Subscription $subscription): array
    {
        $array = [];
        $array['id'] = $subscription->getId();
        $array['customer_id'] = $subscription->getCustomerId();
        $array['customer_name'] = $subscription->getCustomerName();
        $array['customer_cpf'] = $subscription->getCustomerCpf();
        $array['subscription_plan'] = SubscriptionPlanMap::toArray($subscription->getSubscriptionPlan());
        $array['subscription_plan_name'] = $subscription->getSubscriptionPlanName();
        $array['status'] = $subscription->getStatus();
        $array['start_date'] = $subscription->getStartDate()->format('Y-m-d');
        $array['end_date'] = $subscription->getEndDate()->format('Y-m-d');
        $array['cancel_date'] = !empty($subscription->getCancelDate()) ? $subscription->getCancelDate()->format('Y-m-d') : null;
        $array['cancel_reason'] =  $subscription->getCancelReason();
        $array['total_value_without_discount'] =  $subscription->getTotalValueWithoutDiscount();
        $array['total_value'] =  $subscription->getTotalValue();
        $array['payment_date'] =  !empty($subscription->getPaymentDate()) ? $subscription->getPaymentDate()->format('Y-m-d') : null;
        $array['discount_type'] = $subscription->getDiscount()->getDiscountType();
        $array['discount_value'] = $subscription->getDiscount()->getDiscountValue();
        $array['subscription_services'] = [];
        foreach ($subscription->getSubscriptionServices() as $subscription_service) {
            $array['subscription_services'][] = SubscriptionServiceMap::toArray($subscription_service);
        }
        
        return $array;
    }

    public static function toPersistance(Subscription $subscription): array
    {
        $array = [];
        $array['id'] = $subscription->getId();
        $array['customer_id'] = $subscription->getCustomerId();
        $array['customer_name'] = $subscription->getCustomerName();
        $array['customer_cpf'] = $subscription->getCustomerCpf();
        $array['subscription_plan_id'] = $subscription->getSubscriptionPlan()->getId();
        $array['subscription_plan_name'] = $subscription->getSubscriptionPlanName();
        $array['status'] = $subscription->getStatus();
        $array['start_date'] = $subscription->getStartDate()->setTimezone(new \DateTimeZone("UTC"))->format('Y-m-d');
        $array['end_date'] = $subscription->getStartDate()->setTimezone(new \DateTimeZone("UTC"))->format('Y-m-d');
        $array['cancel_date'] = !empty($subscription->getCancelDate()) ? $subscription->getCancelDate()->setTimezone(new \DateTimeZone("UTC"))->format('Y-m-d') : null;
        $array['cancel_reason'] =  $subscription->getCancelReason();
        $array['total_value_without_discount'] =  $subscription->getTotalValueWithoutDiscount();
        $array['total_value'] =  $subscription->getTotalValue();
        $array['payment_date'] =  !empty($subscription->getPaymentDate()) ? $subscription->getPaymentDate()->setTimezone(new \DateTimeZone("UTC"))->format('Y-m-d') : null;
        $array['discount_type'] = $subscription->getDiscount()->getDiscountType();
        $array['discount_value'] = $subscription->getDiscount()->getDiscountValue();
        
        return $array;
    }

    public static function toEntity(array $fields, SubscriptionPlan $subscriptionPlan): ?Subscription
    {
        $start_date = DateTime::createDateTimeObjFromDateString($fields['start_date']);
        $subscription = new Subscription(
            $fields['id'],
            $fields['customer_id'],
            $fields['customer_name'],
            $fields['customer_cpf'],
            $subscriptionPlan,
            $start_date
        );
        //Set End Date
        try {
            $end_date = DateTime::createDateTimeObjFromDateString($fields['end_date']);
            $subscription->updateEndDate($end_date);
        } catch(\Exception $e) {

        }
        //Set canceling
        try {
            if (! empty($fields['cancel_reason'])) {
                $cancel_date = DateTime::createDateTimeObjFromDateString($fields['cancel_date']);
                $subscription->cancel($cancel_date, $fields['cancel_reason']);
            }
        } catch(\Exception $e) {
            throw new \DomainException("Data de cancelamento está inválida.");
        }
        $subscription->updateTotalValue($fields['total_value']);
        //Set Payment Date
        try {
            if (! empty($fields['payment_date'])) {
                $payment_date = DateTime::createDateTimeObjFromDateString($fields['payment_date']);
                $subscription->pay($payment_date);
            }
        } catch(\Exception $e) {
            throw new \DomainException("Data de pagamento está inválida.");
        }
        $subscription->updateDiscount($fields['discount_type'], $fields['discount_value']);
        //foreach ($fields['subscription_services'] as $subscription_service_fields) {
        //    $subscription_service = SubscriptionServiceMap::toEntity($subscription_service_fields);
        //    if (! empty($subscription_service)) {
        //        $subscription->addSubscriptionService($subscription_service);
        //    }
        //}
        $subscription->updateSubscriptionPlanName($fields['subscription_plan_name']);

        return $subscription;
    }
}