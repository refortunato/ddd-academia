<?php

namespace Academia\Subscription\Domain\ValueObjects;

use Academia\Subscription\Domain\Enum\DiscountType;

class Discount
{
    private string $discount_type;
    private float $discount_value;

    public function __construct(
        string $discount_type,
        float $discount_value
    )
    {
        if (! in_array($discount_type, DiscountType::getValues())) {
            throw new \DomainException("Tipo de desconto é inválido. O valor deve estar entre ".implode(", ", DiscountType::getValues()));
        }
        $this->discount_type = $discount_type;
        if ($discount_value < 0) {
            throw new \DomainException("Valor de desconto não pode ser menor que 0.");
        }
        $this->discount_value = $discount_value;
    }

    public function getDiscountType(): string
    {
        return $this->discount_type;
    }

    public function getDiscountValue(): float
    {
        return $this->discount_value;
    }

    public function applyDiscount(float $value): float
    {
        if (empty($this->discount_type) || empty($this->discount_value)) {
            return $value;
        }

        if ($this->discount_type === DiscountType::PERCENT) {
            $value_with_discount =  $value - (($this->getDiscountValue() / 100) * $value);
        }
        else if ($this->discount_type === DiscountType::VALUE) {
            $value_with_discount =  $value - $this->getDiscountValue();
        }

        if ($value_with_discount < 0) {
            throw new \DomainException("Valor com desconto não pode ficar abaixo de 0.");
        }

        return $value_with_discount;
    }
}