<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateApplicationRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
{
    return [
        'application_code' => 'sometimes|string|max:255',
        'client_id'        => 'sometimes|exists:clients,id',
        'career_id'        => 'sometimes|exists:careers,id',
        'status_id'        => 'sometimes|exists:statuses,id',
        'remarks'          => 'nullable|string|max:1000',
    ];
}

}
