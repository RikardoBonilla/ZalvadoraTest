<?php

namespace App\Domain\Company;

interface CompanyRepositoryInterface
{
    public function findById(int $id): ?Company;
    public function save(Company $company): Company;
    // Podríamos añadir más métodos específicos después, como:
    // public function findActiveSubscriptionFor(int $companyId): ?Subscription;
}