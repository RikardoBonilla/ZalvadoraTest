<?php

namespace App\Application\Plan\Delete;

use App\Domain\Plan\PlanRepositoryInterface;

class DeletePlanUseCase
{
    public function __construct(
        private readonly PlanRepositoryInterface $planRepository
    ) {}

    public function execute(int $id): bool
    {
        return $this->planRepository->delete($id);
    }
}