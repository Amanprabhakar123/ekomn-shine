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
            'gst' => '18',
            'hsn' => '123456',
            'duration' => '14', // in days
            'features' => json_encode([
                'inventory_count' => 30,
                'download_count' => 30,
                'price_and_stock' => true,
                'reseller_program' => false,
                'shine_program' => false,
            ]),
            'status' => Plan::STATUS_ACTIVE,
        ]);

        Plan::create([
            'name' => 'Essential',
            'description' => 'Essential',
            'price' => 1999.00,
            'gst' => '18',
            'hsn' => '123456',
            'razorpay_plan_id' => 'plan_OtiZBy9KHyUi6P',
            'duration' => '30', // in days
            'features' => json_encode([
               'inventory_count' => 100,
                'download_count' => 100,
                'price_and_stock' => true,
                'reseller_program' => false,
                'shine_program' => false,
            ]),
            'status' => Plan::STATUS_ACTIVE,
        ]);

        Plan::create([
            'name' => 'Essential - 1 year',
            'description' => 'Essential',
            'price' => round(1999.00 * 12 * 0.93),
            'gst' => '18',
            'hsn' => '123456',
            'razorpay_plan_id' => 'plan_OtihZhsKVRiLcj',
            'duration' => '365', // in days
            'features' => json_encode([
                'inventory_count' => 100,
                'download_count' => 100,
                'price_and_stock' => true,
                'reseller_program' => false,
                'shine_program' => false,
            ]),
            'status' => Plan::STATUS_ACTIVE,
        ]);

        Plan::create([
            'name' => 'Booster',
            'description' => 'Booster',
            'price' => 2999.00,
            'gst' => '18',
            'hsn' => '123456',
            'razorpay_plan_id' => 'plan_OtjEApSpotR4v3',
            'duration' => '30', // in days
            'features' => json_encode([
                'inventory_count' => 500,
                'download_count' => 500,
                'price_and_stock' => true,
                'reseller_program' => true,
                'shine_program' => true,
            ]),
            'status' => Plan::STATUS_ACTIVE,
        ]);

        Plan::create([
            'name' => 'Booster - 1 year',
            'description' => 'Booster',
            'price' => round(2999.00 * 12 * 0.93),
            'gst' => '18',
            'hsn' => '123456',
            'razorpay_plan_id' => 'plan_OtjFcgBUngXQjS',
            'duration' => '365', // in days
            'features' => json_encode([
                'inventory_count' => 500,
                'download_count' => 500,
                'price_and_stock' => true,
                'reseller_program' => true,
                'shine_program' => true,
            ]),
            'status' => Plan::STATUS_ACTIVE,
        ]);

        Plan::create([
            'name' => 'Trade Hub',
            'description' => 'Trade Hub',
            'price' => 7999.00,
            'gst' => '18',
            'hsn' => '123456',
            'razorpay_plan_id' => 'plan_OtjBE7aXTMlHZr',
            'duration' => '30', // in days
            'features' => json_encode([
                'inventory_count' => 1000,
                'download_count' => 1000,
                'price_and_stock' => true,
                'reseller_program' => true,
                'shine_program' => true,
            ]),
            'status' => Plan::STATUS_ACTIVE,
        ]);

        Plan::create([
            'name' => 'Trade Hub - 1 year',
            'description' => 'Trade Hub',
            'price' => round(7999.00 * 12 * 0.93),
            'gst' => '18',
            'hsn' => '123456',
            'razorpay_plan_id' => 'plan_OtjD01hRb3VZtR',
            'duration' => '365', // in days
            'features' => json_encode([
                'inventory_count' => 1000,
                'download_count' => 1000,
                'price_and_stock' => true,
                'reseller_program' => true,
                'shine_program' => true,
            ]),
            'status' => Plan::STATUS_ACTIVE,
        ]);

        Plan::create([
            'name' => 'Enterprise',
            'description' => 'Enterprise',
            'price' => 11999.00,
            'gst' => '18',
            'hsn' => '123456',
            'razorpay_plan_id' => 'plan_OtjGpBABg4OMct',
            'duration' => '30', // in days
            'features' => json_encode([
               'inventory_count' => 2000,
                'download_count' => 2000,
                'price_and_stock' => true,
                'reseller_program' => true,
                'shine_program' => true,
            ]),
            'status' => Plan::STATUS_ACTIVE,
        ]);

        Plan::create([
            'name' => 'Enterprise - 1 year',
            'description' => 'Enterprise',
            'price' => round(11999.00 * 12 * 0.93),
            'gst' => '18',
            'hsn' => '123456',
            'razorpay_plan_id' => 'plan_OtjIAvcuutdEuk',
            'duration' => '365', // in days
            'features' => json_encode([
               'inventory_count' => 2000,
                'download_count' => 2000,
                'price_and_stock' => true,
                'reseller_program' => true,
                'shine_program' => true,
            ]),
            'status' => Plan::STATUS_ACTIVE,
        ]);

        \DB::statement('SET FOREIGN_KEY_CHECKS=1');

    }
}
