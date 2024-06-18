<?php

namespace Database\Seeders;

use App\Models\Category;
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
          $categoryData =  Category::create([
                'name' => $category,
                'slug' => $slug,
                'is_active' => true,
                'depth' => 0
            ]);

            $categoryData->root_parent_id = $categoryData->id;
            $categoryData->save();
        }
    }
}
