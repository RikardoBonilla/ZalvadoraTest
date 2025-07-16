<?php

namespace App\Application\Company\ChangePlan;

use App\Domain\Company\CompanyRepositoryInterface;
use App\Domain\Company\Subscription;
use App\Domain\Plan\PlanRepositoryInterface;
use DateTime;
use Exception;

class ChangeCompanyPlanUseCase
{
    public function __construct(
        private readonly CompanyRepositoryInterface $companyRepository,
        private readonly PlanRepositoryInterface $planRepository
    ) {}

    public function execute(ChangeCompanyPlanDTO $dto): void
    {
        // 1. Validar que el nuevo plan existe
        $newPlan = $this->planRepository->findById($dto->newPlanId);
        if (!$newPlan) {
            throw new Exception("El nuevo plan no existe.");
        }

        // 2. Encontrar la suscripción activa actual y finalizarla
        $activeSubscription = $this->companyRepository->findActiveSubscriptionFor($dto->companyId);
        if ($activeSubscription) {
            if ($activeSubscription->planId === $dto->newPlanId) {
                throw new Exception("La empresa ya está suscrita a este plan.");
            }
            $activeSubscription->endDate = new DateTime();
            $this->companyRepository->saveSubscription($activeSubscription);
        }

        // 3. Crear la nueva suscripción activa
        $newSubscription = new Subscription(
            id: null,
            companyId: $dto->companyId,
            planId: $dto->newPlanId,
            startDate: new DateTime(),
            endDate: null
        );
        $this->companyRepository->saveSubscription($newSubscription);
    }
}