<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @OA\Schema(
 * title="Update Plan Request",
 * description="Datos para la actualización de un plan.",
 * type="object"
 * )
 */
class UpdatePlanRequest extends FormRequest
{
    /**
     * @OA\Property(property="name", type="string", example="Plan Básico Plus")
     * @OA\Property(property="price", type="number", format="float", example=25.50)
     * @OA\Property(property="user_limit", type="integer", example=15)
     * @OA\Property(property="features", type="array", @OA\Items(type="string"), example={"Soporte mejorado"})
     */
    public function rules(): array
    {
        return [
            'name' => 'sometimes|required|string|max:255',
            'price' => 'sometimes|required|numeric|min:0',
            'user_limit' => 'sometimes|required|integer|min:1',
            'features' => 'sometimes|array',
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}