<?php

namespace App\Repositories;

use App\Models\Application;

class ApplicationRepository extends BaseRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model(): string
    {
        return Application::class;
    }

    /**
     * Specify searchable fields
     *
     * @return array
     */
    public function getFieldsSearchable(): array
    {
        return [
            'application_code',
            'client_id',
            'career_id',
            'status_id',
            'remarks'
        ];
    }
}
