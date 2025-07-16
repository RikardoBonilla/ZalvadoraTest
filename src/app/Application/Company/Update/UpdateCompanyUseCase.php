<?php

namespace App\Application\Company\Update;

use App\Domain\Company\CompanyRepositoryInterface;

class UpdateCompanyUseCase
{
    public function __construct(
        private readonly CompanyRepositoryInterface $companyRepository
    ) {}

    public function execute(UpdateCompanyDTO $dto): ?\App\Domain\Company\Company
    {
        $company = $this->companyRepository->findById($dto->id);

        if (!$company) {
            return null; // O lanzar excepción
        }

        $company->name = $dto->name;
        // Aquí podríamos actualizar más campos si el DTO los tuviera

        return $this->companyRepository->save($company);
    }
}