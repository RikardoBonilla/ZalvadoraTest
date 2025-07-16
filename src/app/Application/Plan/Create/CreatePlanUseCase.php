<?php

namespace App\Application\Plan\Create;

use App\Domain\Plan\Plan;
use App\Domain\Plan\PlanRepositoryInterface;

class CreatePlanUseCase
{
    public function __construct(
        private readonly PlanRepositoryInterface $planRepository
    ) {}

    public function execute(CreatePlanDTO $dto): Plan
    {
        // 1. Creamos la entidad de Dominio a partir de los datos del DTO
        $plan = new Plan(
            id: null,
            name: $dto->name,
            price: $dto->price,
            userLimit: $dto->userLimit,
            features: $dto->features
        );

        // 2. Usamos el repositorio para guardar la nueva entidad
        return $this->planRepository->save($plan);
    }
}