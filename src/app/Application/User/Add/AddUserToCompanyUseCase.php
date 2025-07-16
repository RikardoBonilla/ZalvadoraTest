<?php

namespace App\Application\User\Add;

use App\Domain\Company\CompanyRepositoryInterface;
use App\Domain\Plan\PlanRepositoryInterface;
use App\Domain\User\Exception\UserLimitExceededException;
use App\Domain\User\User;
use App\Domain\User\UserRepositoryInterface;
use Illuminate\Contracts\Hashing\Hasher; // Para encriptar la contraseña

class AddUserToCompanyUseCase
{
    public function __construct(
        private readonly UserRepositoryInterface $userRepository,
        private readonly CompanyRepositoryInterface $companyRepository,
        private readonly PlanRepositoryInterface $planRepository,
        private readonly Hasher $hasher // Inyectamos el servicio de Hashing de Laravel
    ) {}

    public function execute(AddUserToCompanyDTO $dto): User
    {
        // 1. Obtener la suscripción activa de la empresa
        $activeSubscription = $this->companyRepository->findActiveSubscriptionFor($dto->companyId);
        if (!$activeSubscription) {
            throw new \Exception("La empresa no tiene una suscripción activa.");
        }

        // 2. Obtener los detalles del plan para saber el límite de usuarios
        $plan = $this->planRepository->findById($activeSubscription->planId);
        if (!$plan) {
            throw new \Exception("No se encontraron los detalles del plan activo.");
        }

        // 3. Contar los usuarios actuales de la empresa
        $currentUserCount = $this->userRepository->countByCompanyId($dto->companyId);

        // 4. ¡LA VALIDACIÓN CLAVE!
        if ($currentUserCount >= $plan->userLimit) {
            throw new UserLimitExceededException("Límite de usuarios alcanzado para el plan actual.");
        }

        // 5. Crear la entidad de usuario con la contraseña hasheada
        $user = new User(
            id: null,
            companyId: $dto->companyId,
            name: $dto->name,
            email: $dto->email,
            password: $this->hasher->make($dto->password)
        );

        // 6. Guardar el nuevo usuario
        return $this->userRepository->save($user);
    }
}