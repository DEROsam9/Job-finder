<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateClientDocumentRequest extends FormRequest
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
            'remarks' => 'nullable|string|max:255',
            'document_type' => 'required|string|in:cv,good_conduct,passport_copy,id_card',
            'passport_expiry_date' => 'nullable|date',
            'document_url' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
        ];
    }
}
