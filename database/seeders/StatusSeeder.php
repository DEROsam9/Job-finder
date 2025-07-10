<?php

namespace Database\Seeders;

use App\Models\Status;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class StatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $statuses = [
            'Draft',
            'Open',
            'Closed',
            'Under Review',
            'Shortlisted',
            'Interview Scheduled',
            'Interviewed',
            'Offered',
            'Hired',
            'Rejected',
            'Withdrawn',
            'On Hold',
        ];

        foreach ($statuses as $status) {
            Status::updateOrCreate(
                [
                    'code' => strtoupper(Str::slug($status))
                ],
                [
                'name' => $status,
                'code' => strtoupper(Str::slug($status))
            ]);
        }
    }
}
