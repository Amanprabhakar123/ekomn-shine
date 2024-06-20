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
            'Stationery' => [
                'Pens',
                'Notebooks',
                'Markers',
                'Staplers',
            ],
            'Furniture' => [
                'Chairs',
                'Tables',
                'Cabinets',
                'Sofas',
            ],
            'Food and beverage' => [
                'Snacks',
                'Beverages',
                'Canned goods',
                'Dairy products',
            ],
            'Electronics' => [
                'Computers',
                'Smartphones',
                'Televisions',
                'Cameras',
            ],
            'Groceries' => [
                'Fruits',
                'Vegetables',
                'Meat',
                'Bakery',
            ],
            'Baby products' => [
                'Diapers',
                'Baby food',
                'Toys',
                'Clothing',
            ],
            'Gift cards' => [
                'Amazon',
                'eBay',
                'Walmart',
                'Target',
            ],
            'Cleaning supplies' => [
                'Detergents',
                'Disinfectants',
                'Brooms',
                'Mops',
            ],
        ];

        foreach ($categories as $mainCategory => $subCategories) {
            $mainCategorySlug = strtolower(str_replace(' ', '-', $mainCategory));
            // Use Category model to insert main category data
            $mainCategoryData = Category::create([
                'name' => $mainCategory,
                'slug' => $mainCategorySlug,
                'is_active' => true,
                'depth' => 0,
            ]);

            $mainCategoryId = $mainCategoryData->id;

            foreach ($subCategories as $subCategory) {
                $subCategorySlug = strtolower(str_replace(' ', '-', $subCategory));
                // Use Category model to insert sub category data
                $subCategoryData = Category::create([
                    'name' => $subCategory,
                    'slug' => $subCategorySlug,
                    'is_active' => true,
                    'depth' => 1,
                    'parent_id' => $mainCategoryId,
                ]);

                $subCategoryId = $subCategoryData->id;

                // Update the root parent id of the sub category
                $subCategoryData->root_parent_id = $mainCategoryId;
                $subCategoryData->save();
            }
        }
    }
}
