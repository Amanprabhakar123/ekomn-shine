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
        Plan::create([
            'name' => 'Free Trial - 14 days',
            'is_trial_plan' => 1, // 'is_trial_plan' is a boolean field, so it should be '1' or '0
            'description' => 'Free Trial',
            'price' => 0.00,
            'duration' => '14', // in days
            'features' => json_encode([
                'feature1' => 'Feature 1',
                'feature2' => 'Feature 2',
                'feature3' => 'Feature 3',
            ]),
            'status' => 1,
        ]);

        Plan::create([
            'name' => 'Essential',
            'description' => 'Essential',
            'price' => 1999.00,
            'duration' => '30', // in days
            'features' => json_encode([
                'feature1' => 'Feature 1',
                'feature2' => 'Feature 2',
                'feature3' => 'Feature 3',
            ]),
            'status' => 1,
        ]);

        Plan::create([
            'name' => 'Essential - 1 year',
            'description' => 'Essential',
            'price' => round(1999.00 * 12 * 0.93),
            'duration' => '365', // in days
            'features' => json_encode([
                'feature1' => 'Feature 1',
                'feature2' => 'Feature 2',
                'feature3' => 'Feature 3',
            ]),
            'status' => 1,
        ]);

        Plan::create([
            'name' => 'Most Popular',
            'description' => 'Booster',
            'price' => 2999.00,
            'duration' => '30', // in days
            'features' => json_encode([
                'feature1' => 'Feature 1',
                'feature2' => 'Feature 2',
                'feature3' => 'Feature 3',
            ]),
            'status' => 1,
        ]);

        Plan::create([
            'name' => 'Most Popular - 1 year',
            'description' => 'Booster',
            'price' => round(2999.00 * 12 * 0.93),
            'duration' => '365', // in days
            'features' => json_encode([
                'feature1' => 'Feature 1',
                'feature2' => 'Feature 2',
                'feature3' => 'Feature 3',
            ]),
            'status' => 1,
        ]);

        Plan::create([
            'name' => 'Trade Hub',
            'description' => 'Trade Hub',
            'price' => 7999.00,
            'duration' => '30', // in days
            'features' => json_encode([
                'feature1' => 'Feature 1',
                'feature2' => 'Feature 2',
                'feature3' => 'Feature 3',
            ]),
            'status' => 1,
        ]);

        Plan::create([
            'name' => 'Trade Hub - 1 year',
            'description' => 'Trade Hub',
            'price' => round(7999.00 * 12 * 0.93),
            'duration' => '365', // in days
            'features' => json_encode([
                'feature1' => 'Feature 1',
                'feature2' => 'Feature 2',
                'feature3' => 'Feature 3',
            ]),
            'status' => 1,
        ]);

        Plan::create([
            'name' => 'Enterprise',
            'description' => 'Enterprise',
            'price' => 11999.00,
            'duration' => '30', // in days
            'features' => json_encode([
                'feature1' => 'Feature 1',
                'feature2' => 'Feature 2',
                'feature3' => 'Feature 3',
            ]),
            'status' => 1,
        ]);

        Plan::create([
            'name' => 'Enterprise - 1 year',
            'description' => 'Enterprise',
            'price' => round(11999.00 * 12 * 0.93),
            'duration' => '365', // in days
            'features' => json_encode([
                'feature1' => 'Feature 1',
                'feature2' => 'Feature 2',
                'feature3' => 'Feature 3',
            ]),
            'status' => 1,
        ]);
    }
}
