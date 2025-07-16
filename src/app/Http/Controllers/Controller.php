<?php

namespace App\Http\Controllers;

/**
 * @OA\Info(
 * version="1.0.0",
 * title="ZalvadoraTest API Documentation",
 * description="API para el sistema de gestión de suscripciones de la prueba técnica."
 * )
 * @OA\SecurityScheme(
 * securityScheme="sanctum",
 * type="http",
 * scheme="bearer",
 * bearerFormat="JWT",
 * description="Autenticación con token Bearer (Sanctum)"
 * )
 */
abstract class Controller
{
    //
}