<?php

namespace Database\Seeders;

use App\Models\Career;
use App\Models\JobCategory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class JobCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            'SALES' => [
                'Sales Officer',
                'Sales Manager',
                'Assistant Sales Manager',
                'Sales Executive',
                'Retail Sales Associate',
                'Inside Sales Representative',
                'Outdoor Sales Representative',
                'Sales Analyst',
                'Sales Coordinator',
            ],
            'ADMINISTRATION' => [
                'Office Secretary',
                'Administrative Assistant',
                'Executive Assistant',
                'Office Manager',
                'Receptionist',
                'Front Office Executive',
                'Office Messenger',
                'Office Cleaner',
            ],
            'HOSPITALITY & TOURISM' => [
                'Hotel Front Desk Agent',
                'Housekeeping Attendant',
                'Waiter/Waitress',
                'Chef / Cook',
                'Barista / Bartender',
                'Concierge',
                'Restaurant Supervisor',
                'Tour Guide',
            ],
            'CONSTRUCTION' => [
                'Site Supervisor',
                'Civil Engineer',
                'Electrician',
                'Plumber',
                'Mason',
                'Painter',
                'Construction Laborer',
                'Safety Officer',
                'Quantity Surveyor',
                'Crane Operator',
            ],
            'WAREHOUSING & LOGISTICS' => [
                'Warehouse Associate',
                'Forklift Operator',
                'Inventory Clerk',
                'Logistics Coordinator',
                'Supply Chain Assistant',
                'Delivery Driver',
                'Picker/Packer',
                'Shipping & Receiving Clerk',
                'Materials Handler',
                'Warehouse Supervisor',
            ],
        ];

        foreach ($categories as $categoryName => $jobTitles) {
            $jobCategory = JobCategory::create([
                'name' => $categoryName,
                'desc' => "$categoryName related roles.",
                'slug' => Str::slug($categoryName),
            ]);

            foreach ($jobTitles as $title) {
                Career::create([
                    'name' => $title,
                    'slug' => Str::slug($title),
                    'description' => "$title description",
                    'job_category_id' => $jobCategory->id,
                    'status_id' => 1, // Assuming 1 = Active
                    'slots' => rand(1, 20),
                ]);
            }
        }
    }
}
