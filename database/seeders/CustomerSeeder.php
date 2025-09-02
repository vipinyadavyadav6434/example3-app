<?php

namespace Database\Seeders;

use App\Models\Customer;
use Illuminate\Database\Seeder;

class CustomerSeeder extends Seeder
{
    public function run(): void
    {
        $customers = [
            [
                'name' => 'Alice Brown',
                'email' => 'alice.brown@example.com',
                'phone' => '+1-555-0201',
                'address' => '123 Main St, New York, NY 10001',
                'is_online' => true,
            ],
            [
                'name' => 'Bob Wilson',
                'email' => 'bob.wilson@example.com',
                'phone' => '+1-555-0202',
                'address' => '456 Oak Ave, Los Angeles, CA 90210',
                'is_online' => false,
            ],
            [
                'name' => 'Carol Davis',
                'email' => 'carol.davis@example.com',
                'phone' => '+1-555-0203',
                'address' => '789 Pine Rd, Chicago, IL 60601',
                'is_online' => true,
            ],
            [
                'name' => 'Dan Miller',
                'email' => 'dan.miller@example.com',
                'phone' => '+1-555-0204',
                'address' => '321 Elm St, Houston, TX 77001',
                'is_online' => true,
            ],
            [
                'name' => 'Eva Rodriguez',
                'email' => 'eva.rodriguez@example.com',
                'phone' => '+1-555-0205',
                'address' => '654 Maple Dr, Phoenix, AZ 85001',
                'is_online' => false,
            ],
        ];

        foreach ($customers as $customer) {
            Customer::create($customer);
        }
    }
}
