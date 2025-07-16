<?php

namespace App\Infrastructure\Persistence\Eloquent\Repositories;

use App\Domain\Company\Company;
use App\Domain\Company\CompanyRepositoryInterface;
use App\Infrastructure\Persistence\Eloquent\Models\CompanyModel;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Domain\Company\Subscription;
use App\Infrastructure\Persistence\Eloquent\Models\SubscriptionModel;

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

    public function addSubscription(\App\Domain\Company\Subscription $subscription): \App\Domain\Company\Subscription
    {
        $subscriptionModel = \App\Infrastructure\Persistence\Eloquent\Models\SubscriptionModel::create([
            'company_id' => $subscription->companyId,
            'plan_id' => $subscription->planId,
            'start_date' => $subscription->startDate,
            'end_date' => $subscription->endDate,
        ]);

        $subscription->id = $subscriptionModel->id;
        return $subscription;
    }

    public function saveSubscription(Subscription $subscription): Subscription
    {
        $subscriptionModel = SubscriptionModel::updateOrCreate(
            ['id' => $subscription->id],
            [
                'company_id' => $subscription->companyId,
                'plan_id' => $subscription->planId,
                'start_date' => $subscription->startDate,
                'end_date' => $subscription->endDate,
            ]
        );

        $subscription->id = $subscriptionModel->id;
        return $subscription;
    }

    public function findActiveSubscriptionFor(int $companyId): ?Subscription
    {
        $subscriptionModel = SubscriptionModel::where('company_id', $companyId)
                                              ->whereNull('end_date')
                                              ->first();

        if (!$subscriptionModel) {
            return null;
        }

        return new Subscription(
            $subscriptionModel->id,
            $subscriptionModel->company_id,
            $subscriptionModel->plan_id,
            $subscriptionModel->start_date,
            $subscriptionModel->end_date
        );
    }

    public function findAll(): array
    {
        return CompanyModel::all()->map(function ($companyModel) {
            return new Company(
                $companyModel->id,
                $companyModel->name,
                $companyModel->email
            );
        })->all();
    }
}