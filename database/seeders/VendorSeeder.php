<?php

namespace Database\Seeders;

use App\Models\Vendor;
use Illuminate\Database\Seeder;

class VendorSeeder extends Seeder
{
    public function run(): void
    {
        $vendors = [
            [
                'name' => 'Dr. Sarah Johnson',
                'email' => 'sarah.johnson@example.com',
                'phone' => '+1-555-0101',
                'specialization' => 'Medical Consultation',
                'description' => 'Experienced medical professional specializing in telemedicine consultations.',
                'hourly_rate' => 150.00,
                'is_online' => true,
                'is_available' => true,
            ],
            [
                'name' => 'John Smith',
                'email' => 'john.smith@example.com',
                'phone' => '+1-555-0102',
                'specialization' => 'Legal Advice',
                'description' => 'Licensed attorney providing legal consultation services.',
                'hourly_rate' => 200.00,
                'is_online' => true,
                'is_available' => true,
            ],
            [
                'name' => 'Maria Garcia',
                'email' => 'maria.garcia@example.com',
                'phone' => '+1-555-0103',
                'specialization' => 'Financial Planning',
                'description' => 'Certified financial planner helping with investment strategies.',
                'hourly_rate' => 120.00,
                'is_online' => false,
                'is_available' => true,
            ],
            [
                'name' => 'David Chen',
                'email' => 'david.chen@example.com',
                'phone' => '+1-555-0104',
                'specialization' => 'IT Support',
                'description' => 'Technical expert providing IT consulting and support services.',
                'hourly_rate' => 80.00,
                'is_online' => true,
                'is_available' => false,
            ],
            [
                'name' => 'Lisa Thompson',
                'email' => 'lisa.thompson@example.com',
                'phone' => '+1-555-0105',
                'specialization' => 'Career Coaching',
                'description' => 'Professional career coach helping with job search and career development.',
                'hourly_rate' => 100.00,
                'is_online' => true,
                'is_available' => true,
            ],
        ];

        foreach ($vendors as $vendor) {
            Vendor::create($vendor);
        }
    }
}
