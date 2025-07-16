<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @OA\Schema(required={"name", "price", "user_limit"})
 */
class StorePlanRequest extends FormRequest
{
    /** @OA\Property(property="name", type="string", example="Plan Corporativo") */
    /** @OA\Property(property="price", type="number", format="float", example=99.99) */
    /** @OA\Property(property="user_limit", type="integer", example=50) */
    /** @OA\Property(property="features", type="array", @OA\Items(type="string"), example={"Soporte 24/7"}) */
    
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'user_limit' => 'required|integer|min:1',
            'features' => 'sometimes|array',
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}