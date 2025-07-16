<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
/**
* @OA\Schema(required={"new_plan_id"})
*/
class ChangeCompanyPlanRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return false;
    }

    /** @OA\Property(property="new_plan_id", type="integer", example=2) */
    public function rules(): array
    {
        return [
            //
        ];
    }
}
