<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreApplicationRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'client_id'   => 'required|exists:clients,id',
            'payment_id'  => 'required|exists:payments,id',
            'amount'      => 'required|numeric|min:0',
            'balance'     => 'required|numeric|min:0',
        ];
    }
}
