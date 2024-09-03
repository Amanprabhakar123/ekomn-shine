<?php

namespace Database\Seeders;

use App\Models\Plan;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PlanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * This method is responsible for seeding the database with plan data.
     *
     * @return void
     */
    public function run(): void
    {
        // set foreign key check to 0
        \DB::statement('SET FOREIGN_KEY_CHECKS=0');
        Plan::truncate();
        Plan::create([
            'name' => 'Free Trial-14 days',
            'is_trial_plan' => 1, // 'is_trial_plan' is a boolean field, so it should be '1' or '0
            'description' => 'Free Trial',
            'price' => 0.00,
            'duration' => '14', // in days
            'features' => json_encode([
                'inventory_count' => '30',
                'download_count' => '30',
                'price_and_stock' => true,
                'seller_program' => false,
                'shine_program' => false,
            ]),
            'status' => 1,
        ]);

        Plan::create([
            'name' => 'Essential',
            'description' => 'Essential',
            'price' => 1999.00,
            'duration' => '30', // in days
            'features' => json_encode([
               'inventory_count' => '100',
                'download_count' => '100',
                'price_and_stock' => true,
                'seller_program' => false,
                'shine_program' => false,
            ]),
            'status' => 1,
        ]);

        Plan::create([
            'name' => 'Essential - 1 year',
            'description' => 'Essential',
            'price' => round(1999.00 * 12 * 0.93),
            'duration' => '365', // in days
            'features' => json_encode([
                'inventory_count' => '100',
                'download_count' => '100',
                'price_and_stock' => true,
                'seller_program' => false,
                'shine_program' => false,
            ]),
            'status' => 1,
        ]);

        Plan::create([
            'name' => 'Booster',
            'description' => 'Booster',
            'price' => 2999.00,
            'duration' => '30', // in days
            'features' => json_encode([
                'inventory_count' => '500',
                'download_count' => '500',
                'price_and_stock' => true,
                'seller_program' => true,
                'shine_program' => true,
            ]),
            'status' => 1,
        ]);

        Plan::create([
            'name' => 'Booster - 1 year',
            'description' => 'Booster',
            'price' => round(2999.00 * 12 * 0.93),
            'duration' => '365', // in days
            'features' => json_encode([
                'inventory_count' => '500',
                'download_count' => '500',
                'price_and_stock' => true,
                'seller_program' => true,
                'shine_program' => true,
            ]),
            'status' => 1,
        ]);

        Plan::create([
            'name' => 'Trade Hub',
            'description' => 'Trade Hub',
            'price' => 7999.00,
            'duration' => '30', // in days
            'features' => json_encode([
                'inventory_count' => '1000',
                'download_count' => '1000',
                'price_and_stock' => true,
                'seller_program' => true,
                'shine_program' => true,
            ]),
            'status' => 1,
        ]);

        Plan::create([
            'name' => 'Trade Hub - 1 year',
            'description' => 'Trade Hub',
            'price' => round(7999.00 * 12 * 0.93),
            'duration' => '365', // in days
            'features' => json_encode([
                'inventory_count' => '1000',
                'download_count' => '1000',
                'price_and_stock' => true,
                'seller_program' => true,
                'shine_program' => true,
            ]),
            'status' => 1,
        ]);

        Plan::create([
            'name' => 'Enterprise',
            'description' => 'Enterprise',
            'price' => 11999.00,
            'duration' => '30', // in days
            'features' => json_encode([
               'inventory_count' => '2000',
                'download_count' => '2000',
                'price_and_stock' => true,
                'seller_program' => true,
                'shine_program' => true,
            ]),
            'status' => 1,
        ]);

        Plan::create([
            'name' => 'Enterprise - 1 year',
            'description' => 'Enterprise',
            'price' => round(11999.00 * 12 * 0.93),
            'duration' => '365', // in days
            'features' => json_encode([
               'inventory_count' => '2000',
                'download_count' => '2000',
                'price_and_stock' => true,
                'seller_program' => true,
                'shine_program' => true,
            ]),
            'status' => 1,
        ]);

        \DB::statement('SET FOREIGN_KEY_CHECKS=1');

    }
}
