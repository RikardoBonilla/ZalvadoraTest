<?php

    namespace App\Http\Requests;
    
    use Illuminate\Foundation\Http\FormRequest;

    /**
     * @OA\Schema(title="Update User Request")
     */
    class UpdateUserRequest extends FormRequest {
        /** @OA\Property(property="name", type="string", example="John Doe Updated") */
        /** @OA\Property(property="email", type="string", format="email", example="john.updated@empresa.com") */
        public function rules(): array {
            // Ignoramos el email del usuario actual al validar que sea único
            $userId = $this->route('user')->id;
            return [
                'name' => 'sometimes|required|string|max:255',
                'email' => 'sometimes|required|email|unique:users,email,' . $userId,
            ];
        }
        public function authorize(): bool { return true; }
    }