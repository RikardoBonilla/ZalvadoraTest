<?php

namespace App\Infrastructure\Persistence\Eloquent\Repositories;

use App\Domain\Plan\Plan;
use App\Domain\Plan\PlanRepositoryInterface;
use App\Infrastructure\Persistence\Eloquent\Models\PlanModel;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class PlanRepository implements PlanRepositoryInterface
{
    public function findById(int $id): ?Plan
    {
        try {
            $planModel = PlanModel::findOrFail($id);
            return new Plan(
                $planModel->id,
                $planModel->name,
                $planModel->price,
                $planModel->user_limit,
                $planModel->features ?? []
            );
        } catch (ModelNotFoundException) {
            return null;
        }
    }

    public function save(Plan $plan): Plan
    {
        $planModel = PlanModel::updateOrCreate(
            ['id' => $plan->id],
            [
                'name' => $plan->name,
                'price' => $plan->price,
                'user_limit' => $plan->userLimit,
                'features' => $plan->features,
            ]
        );

        $plan->id = $planModel->id;
        return $plan;
    }

    public function delete(int $id): bool
    {
        return PlanModel::destroy($id) > 0;
    }

    public function findAll(): array
    {
        return PlanModel::all()->map(function ($planModel) {
            return new Plan(
                $planModel->id,
                $planModel->name,
                $planModel->price,
                $planModel->user_limit,
                $planModel->features ?? []
            );
        })->all();
    }
}