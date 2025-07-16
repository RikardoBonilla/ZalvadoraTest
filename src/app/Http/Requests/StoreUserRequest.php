<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
/**
 * @OA\Schema(required={"name", "email", "password"})
 */
class StoreUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    /** @OA\Property(property="name", type="string", example="Jane Doe") */
    /** @OA\Property(property="email", type="string", format="email", example="jane.doe@empresa.com") */
    /** @OA\Property(property="password", type="string", format="password", example="password123") */
    public function rules(): array
    {
        return [
            //
        ];
    }
}
