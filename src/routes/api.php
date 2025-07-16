<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\AuthController;
use App\Http\Controllers\Api\V1\PlanController;
use App\Http\Controllers\Api\V1\CompanyController;
use App\Http\Controllers\Api\V1\CompanyUserController;

Route::prefix('v1')->group(function () {
    Route::apiResource('plans', PlanController::class);
    Route::post('/login', [AuthController::class, 'login']); // <-- AÑADE ESTA LÍNEA

    Route::middleware('auth:sanctum')->group(function () {
        // ... (rutas protegidas)
    });
});

Route::apiResource('companies', CompanyController::class);
Route::post('companies/{company}/change-plan', [CompanyController::class, 'changePlan']);

Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('companies.users', CompanyUserController::class);
});
