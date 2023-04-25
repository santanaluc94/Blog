<?php

namespace App\Model;

interface RepositoryInterface
{
    public function save(EntityInterface $entity): ?EntityInterface;

    public function load(int $id): ?EntityInterface;

    public function removeById(int $id): bool;

    public function getCollection(): ?array;
}
