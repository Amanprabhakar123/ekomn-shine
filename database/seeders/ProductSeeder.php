<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ProductInventory;
use App\Models\ProductVariation;
use App\Models\ProductVariationMedia;
use Database\Factories\ProductInventoryFactory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $productInventories = ProductInventory::factory(10)->create();

         // For each ProductInventory, create 5 ProductVariations
         foreach ($productInventories as $productInventory) {
            ProductVariation::factory(5)->create($productInventory);
        }

        foreach ($productInventories as $productInventory) {
            ProductVariationMedia::factory(5)->create($productInventory);
        }
    }
}
