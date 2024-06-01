<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\CanHandle;

class CanHandleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $canHandleData = [
            [
                'name' => 'FBA Labeling',
                'is_active' => true,
            ],
            [
                'name' => 'Bulk Orders',
                'is_active' => true,
            ],
            [
                'name' => 'Returns',
                'is_active' => true,
            ],
            [
                'name' => 'Product Customization',
                'is_active' => true,
            ],
        ];

        CanHandle::insert($canHandleData);
    }
}
