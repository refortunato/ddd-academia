<?php

namespace Academia\Core\Helpers;

use Academia\Core\Entity;

class ListOfEntity
{
    private array $list = [];
 
    public function add(Entity $entity): void
    {
        $this->list[] = $entity;
    }

    public function update(Entity $entity): bool
    {
        for ($i = 0; $i < count($this->list); $i++) {
            if ($this->list[$i]->getId() == $entity->getId()) {
                $this->list[$i] = $entity;
                return true;
            }
        }
        return false;
    }

    public function count(): int
    {
        return count($this->list);
    }

    public function getAll(): array
    {
        return $this->list;
    }

    public function removeLast(): void
    {
        array_pop($this->list);
    }

    public function removeFirst(): void
    {
        array_shift($this->list);
    }

    public function removeFromId($id): void
    {
        for($i = 0; $i < count($this->list); $i++) {
            if ($this->list[$i]->getId() === $id) {
                unset($this->list[$i]);
                $this->list = array_values($this->list);
            }
        }
    }

    public function getFromId($id): ?Entity
    {
        foreach ($this->list as $entity) {
            if ($entity->getId() == $id) {
                return $entity;
            }
        }
        return null;
    }
}