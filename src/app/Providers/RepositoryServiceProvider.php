<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Domain\Plan\PlanRepositoryInterface;
use App\Infrastructure\Persistence\Eloquent\Repositories\PlanRepository; // <- Revisa esta línea

class RepositoryServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(
            PlanRepositoryInterface::class, // <- Revisa esta línea
            PlanRepository::class            // <- Revisa esta línea
        );
    }

    public function boot(): void
    {
        //
    }
}