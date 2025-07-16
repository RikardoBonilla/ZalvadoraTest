<?php

namespace App\Infrastructure\Persistence\Eloquent\Repositories;

use App\Domain\Company\Company;
use App\Domain\Company\CompanyRepositoryInterface;
use App\Infrastructure\Persistence\Eloquent\Models\CompanyModel;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class CompanyRepository implements CompanyRepositoryInterface
{
    public function findById(int $id): ?Company
    {
        try {
            $companyModel = CompanyModel::findOrFail($id);
            return new Company(
                $companyModel->id,
                $companyModel->name,
                $companyModel->email
            );
        } catch (ModelNotFoundException) {
            return null;
        }
    }

    public function save(Company $company): Company
    {
        $companyModel = CompanyModel::updateOrCreate(
            ['id' => $company->id],
            [
                'name' => $company->name,
                'email' => $company->email,
            ]
        );

        $company->id = $companyModel->id;
        return $company;
    }
}