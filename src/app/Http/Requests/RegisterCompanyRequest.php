<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
/**
 * @OA\Schema(required={"name", "email", "plan_id"})
 */
class RegisterCompanyRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return false;
    }

    /** @OA\Property(property="name", type="string", example="Mi Nueva Empresa") */
    /** @OA\Property(property="email", type="string", format="email", example="contacto@nuevaempresa.com") */
    /** @OA\Property(property="plan_id", type="integer", example=1) */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:companies,email',
            'plan_id' => 'required|integer|exists:plans,id',
        ];
    }
}
