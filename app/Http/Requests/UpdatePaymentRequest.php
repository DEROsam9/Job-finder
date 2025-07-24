<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePaymentRequest extends FormRequest
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
        'client_id' => 'required|exists:clients,id',
        'amount' => 'required|numeric|min:0',
        'status_id' => 'nullable|exists:statuses,id',
        'additional_information' => 'nullable|string',
        'payload' => 'nullable|json',
        'transaction_reference' => 'nullable|string|max:255',
        'transaction_date' => 'nullable|date',
        'remarks' => 'nullable|string|max:500',
        'merchant_request_id' => 'nullable|string|max:255',
        'checkout_request_id' => 'nullable|string|max:255',
    ];
}

}
