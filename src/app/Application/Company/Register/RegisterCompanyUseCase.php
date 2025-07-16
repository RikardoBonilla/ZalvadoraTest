<?php

namespace App\Application\Company\Register;

use App\Domain\Company\Company;
use App\Domain\Company\CompanyRepositoryInterface;
use App\Domain\Company\Subscription;
use App\Domain\Plan\PlanRepositoryInterface;
use DateTime;
use Exception;

class RegisterCompanyUseCase
{
    public function __construct(
        private readonly CompanyRepositoryInterface $companyRepository,
        private readonly PlanRepositoryInterface $planRepository
    ) {}

    public function execute(RegisterCompanyDTO $dto): Company
    {
        // 1. Verificar que el plan existe
        $plan = $this->planRepository->findById($dto->planId);
        if (!$plan) {
            throw new Exception("Plan no encontrado.");
        }

        // 2. Crear y guardar la nueva compañía
        $company = new Company(null, $dto->companyName, $dto->companyEmail);
        $savedCompany = $this->companyRepository->save($company);

        // 3. Crear la suscripción inicial
        $subscription = new Subscription(
            id: null,
            companyId: $savedCompany->id,
            planId: $plan->id,
            startDate: new DateTime(),
            endDate: null // Activa
        );
        // 4. Guardar la suscripción
        $this->companyRepository->saveSubscription($subscription);


        return $savedCompany;
    }
}