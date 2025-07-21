<?php

namespace App\Repositories;

use App\Models\User;

class UserRepository extends BaseRepository
{
    protected $fieldSearchable = [
        "name",
        "phone_number",
        "email"
    ];

    public function getFieldsSearchable(): array
    {
        return $this->fieldSearchable;
    }

    public function model(): string
    {
        return User::class;
    }
    public function findByEmail(string $email): ?User
{
    return $this->model()::where('email', $email)->first();
}

}
