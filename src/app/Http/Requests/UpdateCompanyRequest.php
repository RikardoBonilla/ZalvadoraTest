<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
/**
 * @OA\Schema(title="Update Company Request")
 */
class UpdateCompanyRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return false;
    }

    /** @OA\Property(property="name", type="string", example="Nuevo Nombre Empresa") */
    /** @OA\Property(property="email", type="string", format="email", example="nuevo@email.com") */
    public function rules(): array
    {
        return [
            //
        ];
    }
}
