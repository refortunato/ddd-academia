<?php

namespace Academia\Subscription\Infra\Repositories\InMemory;

use Academia\Subscription\Domain\Entities\Service;
use Academia\Subscription\Domain\Repositories\ServiceRepository;

class ServiceRepositoryInMemory implements ServiceRepository
{
    private $services = [];

    public function getById(string $id): ?Service
    {
        foreach ($this->services as $service) {
            if ($service->getId() == $id) {
                return $service;
            }
        }
        return null;
    }

    public function getAll(): ?Array
    {
        return $this->services;
    }

    public function save(Service $service): ?Service
    {
        for ($i = 0; $i < count($this->services); $i++) {
            if ($this->services[$i]->getId() == $service->getId()) {
                $this->services[$i] = $service;
                return $service;
            }
        }
        $this->services[] = $service;
        return $service;
    }

    public function delete(string $id): bool
    {
        for ($i = 0; $i < count($this->services); $i++) {
            if ($this->services[$i]->getId() == $id) {
                unset($this->services[$i]);
                $this->services = array_values($this->services);
                return true;
            }
        }
        return false;
    }
}