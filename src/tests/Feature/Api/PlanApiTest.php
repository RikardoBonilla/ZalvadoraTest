<?php
namespace Tests\Feature\Api;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PlanApiTest extends TestCase
{
    use RefreshDatabase; // Esto ejecuta migrate:fresh automáticamente para cada prueba

    public function test_can_list_plans(): void
    {
        // 1. Preparación: Usamos el seeder para tener datos
        $this->seed();

        // 2. Acción: Hacemos una petición GET a la API
        $response = $this->getJson('/api/v1/plans');

        // 3. Afirmación: Verificamos que la respuesta es exitosa y tiene datos
        $response->assertStatus(200);
        $response->assertJsonCount(2, 'data'); // Esperamos 2 planes
    }
}