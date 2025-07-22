<?php

namespace App\Repositories;

use App\Models\Career;

class CareerRepository extends BaseRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Career::class;
    }

    /**
     * Specify searchable fields
     *
     * @return array
     */
    public function getFieldsSearchable()
    {
        return [
            'name',
            'slug',
            'description',
            'job_category_id',
            'slots',
        ];
    }
}
