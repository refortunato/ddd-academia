<?php

namespace Academia\Subscription\Application\Services\Service\UpdateService;

use Academia\Subscription\Domain\Enum\StatusService;

class UpdateServiceRequestDto
{
    private string $id;
    private string $name;
    private float $price;
    private string $status;

    public function __construct(
        string $id,
        string $name,
        float $price,
        string $status
    )
    {
        $this->id = $id;
        $this->name = $name;
        $this->price = $price;
        $this->status = $status;

        if (! in_array($this->status, StatusService::getValues())  ) {
            throw new \DomainException("Status do serviço é inválido. Só pode ser informado valor entre: ".implode(', ', StatusService::getValues()));
        }
    }

    public function getId(): string
    {
        return $this->id;
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