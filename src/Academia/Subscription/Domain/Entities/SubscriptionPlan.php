<?php

namespace Academia\Subscription\Domain\Entities;

use Academia\Subscription\Domain\Enum\DiscountType;
use Academia\Core\Entity;
use Academia\Subscription\Domain\ValueObjects\Discount;
use DomainException;

class SubscriptionPlan extends Entity
{
    private string $name;
    private int $total_plan_validity_months;
    private string $discount_type;
    private float $discount_value;

    public function __construct(
        string $id, 
        string $name,
        int $total_plan_validity_months
    )
    {
        parent::__construct($id);
        $this->name = trim($name);
        $this->total_plan_validity_months = $total_plan_validity_months;

        $this->validate();
    }

    /**
     * 
     */
    public function setDiscount(string $type, float $value)
    {
        if (! in_array($type, DiscountType::getValues())  ) {
            throw new \DomainException("Tipo de desconto inválido.");
        }
        $this->discount_value = $value;
        $this->discount_type = $type;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getTotalPlanValidityMonth(): int
    {
        return $this->total_plan_validity_months;
    }

    public function getDiscountType(): string 
    {
        return $this->discount_type;
    }

    public function getDiscountValue(): float 
    {
        return $this->discount_value;
    }

    private function validate(): void
    {
        if ($this->total_plan_validity_months <= 0) {
            throw new \DomainException("Total de meses de validade do plano deve ser maior que 0.");
        }

        if (empty($this->name)) {
            throw new \DomainException("Nome do plano de assinatura precisa ser preenchido.");
        }
    }
}
