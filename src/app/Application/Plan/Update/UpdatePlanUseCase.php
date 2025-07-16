<?php

namespace App\Application\Plan\Update;

use App\Domain\Plan\Plan;
use App\Domain\Plan\PlanRepositoryInterface;

class UpdatePlanUseCase
{
    public function __construct(
        private readonly PlanRepositoryInterface $planRepository
    ) {}

    public function execute(UpdatePlanDTO $dto): ?Plan
    {
        // Primero, buscamos si el plan existe
        $plan = $this->planRepository->findById($dto->id);

        if (!$plan) {
            return null; // O podríamos lanzar una excepción
        }

        // Actualizamos las propiedades de la entidad
        $plan->name = $dto->name;
        $plan->price = $dto->price;
        $plan->userLimit = $dto->userLimit;
        $plan->features = $dto->features;

        // Guardamos los cambios
        return $this->planRepository->save($plan);
    }
}