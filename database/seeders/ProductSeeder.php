<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ProductInventory;
use App\Models\ProductVariation;
use Database\Factories\ProductInventoryFactory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $productInventory = ProductInventory::factory(10)->create();

        foreach ($productInventory as $product) {
            ProductVariation::factory(5)->create($product);
        }
    }
}
