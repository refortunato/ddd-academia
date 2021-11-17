<?php

namespace Academia\Subscription\Application\Services\Service\AddService;

use Academia\Subscription\Domain\Enum\StatusService;

class AddServiceRequestDto
{
    private string $name;
    private float $price;
    private string $status;

    public function __construct(
        string $name,
        float $price,
        string $status
    )
    {
        $this->name = $name;
        $this->price = $price;
        $this->status = $status;

        if (! in_array($this->status, StatusService::getValues())  ) {
            throw new \DomainException("Status do serviço é inválido. Só pode ser informado valor entre: ".implode(', ', StatusService::getValues()));
        }
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getPrice(): float
    {
        return $this->price;
    }

    public function getStatus(): string
    {
        return $this->status;
    }
}