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
        $businessTypesSupplier = [
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

        $businessTypesBuyer = [
            'Retailer',
            'Online Brand',
            'Online Seller',
            'Reseller',
            'Online Store',
        ];

        foreach ($businessTypesSupplier as $type) {
            BusinessType::create([
                'name' => $type,
                'type' => BusinessType::TYPE_SUPPLIER,
                'is_active' => true,
            ]);
        }

        foreach ($businessTypesBuyer as $type) {
            BusinessType::create([
                'name' => $type,
                'type' => BusinessType::TYPE_BUYER,
                'is_active' => true,
            ]);
        }
    }
}
