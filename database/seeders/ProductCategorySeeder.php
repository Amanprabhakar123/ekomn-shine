<?php

namespace Database\Seeders;

use App\Models\ProductCategory;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ProductCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            'Stationery',
            'Furniture',
            'Food and beverage',
            'Electronics',
            'Groceries',
            'Baby products',
            'Gift cards',
            'Cleaning supplies'
        ];

        foreach ($categories as $category) {
            $slug = strtolower(str_replace(' ', '-', $category));
            // Use ProductCategory model to insert data
            ProductCategory::create([
                'name' => $category,
                'slug' => $slug,
                'is_active' => true,
            ]);
        }
    }
}
