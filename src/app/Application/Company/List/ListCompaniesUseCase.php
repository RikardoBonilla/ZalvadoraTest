<?php

namespace App\Application\Company\List;

use App\Domain\Company\CompanyRepositoryInterface;

class ListCompaniesUseCase
{
    public function __construct(
        private readonly CompanyRepositoryInterface $companyRepository
    ) {}

    public function execute(): array
    {
        return $this->companyRepository->findAll();
    }
}