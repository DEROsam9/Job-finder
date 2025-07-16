<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            [
                "name" => "admin",
                "phone_number" => "0123456789",
                "email" => "admin@mail.com",
                "password" => Hash::make("password123")
            ],
            [
                "name" => "john_doe",
                "phone_number" => "0712345678",
                "email" => "john@example.com",
                "password" => Hash::make("secret456")
            ],
            [
                "name" => "jane_doe",
                "phone_number" => "0798765432",
                "email" => "jane@example.com",
                "password" => Hash::make("secure789")
            ]
        ];

        foreach ($users as $user) {
            User::create($user);
        }
    }
}
