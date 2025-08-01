<?php

namespace App\Repositories;

use App\Models\Career;
use App\Models\JobCategory;

class JobCategoryRepository extends BaseRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return JobCategory::class;
    }

    /**
     * Specify searchable fields
     *
     * @return array
     */
    public function getFieldsSearchable()
    {
        return [
            'name', 'slug', 'description', 'status_id'
        ];
    }
}
