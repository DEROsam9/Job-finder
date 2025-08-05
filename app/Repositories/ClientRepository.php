<?php

namespace App\Repositories;

use App\Models\Client;

class ClientRepository extends BaseRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Client::class;
    }

    /**
     * Specify searchable fields
     *
     * @return array
     */
    public function getFieldsSearchable()
    {
        return [
            'surname',
            'first_name',
            'middle_name',
            'status_id',
            'email',
            'phone_number',
            'passport_number',
            'id_number',
            'address',
            'city'
        ];
    }
}
