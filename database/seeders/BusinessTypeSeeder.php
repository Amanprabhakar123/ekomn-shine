<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\BusinessType;

class BusinessTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $businessTypes = [
            'Manufacturer',
            'Supplier',
            'Distributor',
            'Importer',
            'Exporter',
            'Wholesaler',
            'Retailer',
            'Online Brand',
            'Online Seller',
            'Reseller',
            'Online Store',
        ];

        foreach ($businessTypes as $type) {
            BusinessType::create([
                'name' => $type,
                'is_active' => true,
            ]);
        }
    }
}
