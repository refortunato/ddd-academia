<?php

namespace Academia\Subscription\Domain\Entities;

use Academia\Subscription\Domain\Enum\SubscriptionStatus;
use Academia\Core\Entity;
use Academia\Core\Helpers\DateTime;
use Academia\Core\Helpers\ListOfEntity;
use Academia\Subscription\Domain\Enum\SubscriptionDiscountType;
use Academia\Subscription\Domain\ValueObjects\Discount;

class Subscription extends Entity
{
    private string $customer_id;
    private string $customer_name;
    private string $customer_cpf;
    private SubscriptionPlan $subscription_plan;
    private string $subscription_plan_name;
    private ListOfEntity $subscription_services;
    private string $status;
    private \DateTime $start_date;
    private \DateTime $end_date;
    private ?\DateTime $cancel_date;
    private ?string $cancel_reason;
    private float $total_value;
    private float $total_value_without_discount;
    private ?\DateTime $payment_date;
    private Discount $discount;

    public function __construct(
        string $id,
        string $customer_id,
        string $customer_name,
        string $customer_cpf,
        SubscriptionPlan $subscription_plan,
        \DateTime $start_date
    )
    {
        parent::__construct($id);
        $this->customer_id = $customer_id;
        $this->customer_name = $customer_name;
        $this->customer_cpf = $customer_cpf;
        $this->subscription_plan = $subscription_plan;
        $this->updateSubscriptionPlanName($this->subscription_plan->getName());
        $this->start_date = $start_date;
        $this->subscription_services = new ListOfEntity();
        $this->status = SubscriptionStatus::OPENED;
        $this->updateDiscount(
            $this->subscription_plan->getDiscountType(), 
            $this->subscription_plan->getDiscountValue()
        );
        $this->calculateEndDate();
        $this->cancel_date = null;
        $this->cancel_reason = null;
        $this->payment_date = null;
    }

    /**
     * get methods
     */
    public function getCustomerId(): string 
    {
        return $this->customer_id;
    }
    
    public function getCustomerName(): string 
    {
        return $this->customer_name;
    }
    
    public function getCustomerCpf(): string 
    {
        return $this->customer_cpf;
    }
    
    public function getSubscriptionPlan(): SubscriptionPlan 
    {
        return $this->subscription_plan;
    }

    public function getSubscriptionPlanName(): string
    {
        return $this->subscription_plan_name;
    }
        
    public function getStatus(): string 
    {
        return $this->status;
    }
    
    public function getStartDate(): \DateTime 
    {
        return $this->start_date;
    }
    
    public function getEndDate(): \DateTime 
    {
        return $this->end_date;
    }
    
    public function getCancelDate(): ?\DateTime 
    {
        return $this->cancel_date;
    }
    
    public function getCancelReason(): ?string 
    {
        return $this->cancel_reason;
    }
    
    public function getTotalValue(): float 
    {
        return $this->total_value;
    }

    public function getTotalValueWithoutDiscount(): float
    {
        return $this->total_value_without_discount;
    }

    public function getSubscriptionServices(): array
    {
        return $this->subscription_services->getAll();
    }

    public function getPaymentDate(): ?\DateTime
    {
        return $this->payment_date;
    }

    public function getDiscount(): Discount
    {
        return $this->discount;
    }
    
    /**
     * Domain methods
     */
    public function addSubscriptionService(SubscriptionService $subscription_service): void
    {
        $subscription_service_already_exists = $this->subscription_services->getFromId($subscription_service->getId()) !== null;
        if ($subscription_service_already_exists) {
            return;
        }
        $this->subscription_services->add($subscription_service);
        $this->calculateTotalValue();
    }

    public function removeSubscriptionService(string $subscription_service_id): void
    {
        if ($this->subscription_services->count() > 0) {
            $this->subscription_services->removeFromId($subscription_service_id);
        }
        $this->calculateTotalValue();
    }

    private function calculateTotalValue(): void
    {
        $value = 0;
        $sugbscription_services = $this->getSubscriptionServices();
        if (empty($sugbscription_services)) {
            $this->total_value = 0;
            $this->total_value_without_discount = 0;
            return;
        }
        foreach ($sugbscription_services as $sugbscription_service) {
            $value += $sugbscription_service->getServiceValue();
        }
        $this->total_value_without_discount = round($value, 2);
        $this->total_value = round($this->discount->applyDiscount($value), 2);
    }



    private function calculateEndDate(): void
    {
        $total_plan_validity_months = $this->subscription_plan->getTotalPlanValidityMonth();
        $end_date = DateTime::createDateTimeObjFromDateString($this->start_date->format('Y-m-d'));
        $end_date->add( \DateInterval::createFromDateString($total_plan_validity_months.' months'));
        //Vence no fim de semana ? aqui tem a regra para vencer apenas em dias úteis.
        $is_weekend = in_array($end_date->format('N'), [5,6,7]);
        while ($is_weekend) {
            $end_date->add(\DateInterval::createFromDateString('1 day'));
            $is_weekend = in_array($end_date->format('N'), [5,6,7]);
        }
        $this->end_date = $end_date;
    }

    public function cancel(\DateTime $date, string $reason)
    {
        if (! in_array($this->status, [SubscriptionStatus::OPENED, SubscriptionStatus::EXPIRED])) {
            throw new \DomainException("Só é possível cancelar quando estiver em aberto ou expirado.");
        }
        if ($this->start_date->getTimestamp() > $date->getTimestamp()) {
            throw new \DomainException("Data de cancelamento deve ser maior ou igual à data inicial.");
        }
        $reason = trim($reason);
        if (empty($reason)) {
            throw new \DomainException("Motivo de cancelamento deve ser informado.");
        }

        $this->cancel_date = $date;
        $this->cancel_reason = $reason;
        $this->status = SubscriptionStatus::CANCELED;
    }

    public function pay(\DateTime $payment_date)
    {
        if (! in_array($this->status, [SubscriptionStatus::OPENED, SubscriptionStatus::EXPIRED])) {
            throw new \DomainException("Só é possível dar baixa de pagamento quando estiver em aberto ou expirado.");
        }
        $this->payment_date = $payment_date;
        $this->status = SubscriptionStatus::PAID;
    }

    /**
     * Update Methods
     */
    public function updateEndDate(\DateTime $date): void
    {
        if ($this->start_date->getTimestamp() >= $date->getTimestamp()) {
            throw new \DomainException("Data final deve ser maior que a data inicial.");
        } 
        $this->end_date = $date;
    }

    public function updateTotalValue(float $value): void
    {
        if ($value < 0) {
            throw new \DomainException("Valor total não pode ser menor que 0.");
        }
        $this->total_value = $value;
    }

    public function updateDiscount(string $discount_type, float $discount_value): void
    {
        $this->discount = new Discount($discount_type, $discount_value);
        $this->calculateTotalValue();
    }

    public function updateSubscriptionPlanName(string $subscription_plan_name): void
    {
        $this->subscription_plan_name = $subscription_plan_name;
    }
}