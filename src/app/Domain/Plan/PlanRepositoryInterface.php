<?php

namespace App\Domain\Plan;

interface PlanRepositoryInterface
{
    public function findById(int $id): ?Plan;
    public function save(Plan $plan): Plan;
    public function delete(int $id): bool;
    public function findAll(): array;
}