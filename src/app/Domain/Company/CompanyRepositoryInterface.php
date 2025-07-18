<?php

namespace App\Domain\Company;

interface CompanyRepositoryInterface
{
    public function findById(int $id): ?Company;
    public function save(Company $company): Company;
    public function addSubscription(Subscription $subscription): Subscription;
    public function findActiveSubscriptionFor(int $companyId): ?Subscription;
    public function findAll(): array;   
}