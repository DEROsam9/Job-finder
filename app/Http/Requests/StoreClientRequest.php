<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreClientRequest extends FormRequest
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
            'surname_name' => 'required|string|max:255',
            'first_name' => 'required|string|max:255',
            'middle_name' => 'nullable|string|max:255',
            'email' => 'required|email|unique:clients,email',
            'phone_number' => 'required|string|max:20',
            'id_number' => 'required|string|max:20',
            'passport_number' => 'required|string|max:20',
            'id_front' => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'passport_copy' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'passport_expiry' => 'nullable|date',
            'good_conduct' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'job_category' => 'required|exists:job_categories,id',
            'job_title' => 'required|exists:careers,id',
            'experience_brief' => 'nullable|string|max:1000',
            'cv' => 'required|file|mimes:pdf,doc,docx|max:4096',
        ];
    }
}
