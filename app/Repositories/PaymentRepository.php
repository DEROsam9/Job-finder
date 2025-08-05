<?php

namespace App\Repositories;

use App\Models\Payment;

class PaymentRepository extends BaseRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model(): string
    {
        return Payment::class;
    }

    /**
     * Specify searchable fields
     *
     * @return array
     */
    public function getFieldsSearchable(): array
    {
        return [
            'client_id',
            'amount',
            'status_id',
            'transaction_reference',
            'merchant_request_id',
            'checkout_request_id'
        ];
    }
}