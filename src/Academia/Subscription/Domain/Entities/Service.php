<?php

namespace Academia\Subscription\Domain\Entities;

use Academia\Subscription\Domain\Enum\StatusService;
use Academia\Core\Entity;

class Service extends Entity
{
    private string $name;
    private float $price;
    private string $status;

    public function __construct(
        string $id,
        string $name,
        float $price
    )
    {
        parent::__construct($id);
        $this->setName($name);
        $this->setPrice($price);
        $this->activate();
    }

    /**
     * Getters
     */
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

    /**
     * Setters
     */
    public function setName(string $name): void
    {
        $this->name = $name;
        if (empty($this->name)) {
            throw new \DomainException("Nome do servico não pode ser vazio.");
        }
    }

    public function setPrice(float $price): void
    {
        $this->price = $price;
        if ($this->price < 0) {
            throw new \DomainException("Preço do serviço não pode ser menor do que 0.");
        }
    }

    /**
     * Methods
     */
    public function activate(): void
    {
        $this->status = StatusService::ACTIVE;
    }

    public function deactivate(): void
    {
        $this->status = StatusService::INACTIVE;
    }
}