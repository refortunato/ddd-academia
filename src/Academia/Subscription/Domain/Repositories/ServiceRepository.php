<?php

namespace Academia\Subscription\Domain\Repositories;

use Academia\Subscription\Domain\Entities\Service;

interface ServiceRepository
{
    public function getById(string $id): ?Service;
    public function getAll(): ?Array;
    public function save(Service $service): ?Service;
    public function delete(string $id): bool;
}