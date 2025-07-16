<?php

namespace App\Application\Plan\List;

use App\Domain\Plan\PlanRepositoryInterface;

class ListPlansUseCase
{
    public function __construct(
        private readonly PlanRepositoryInterface $planRepository
    ) {}

    /**
     * @return \App\Domain\Plan\Plan[]
     */
    public function execute(): array
    {
        return $this->planRepository->findAll();
    }
}