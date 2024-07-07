<?php

namespace Database\Factories;

use App\Models\ProductInventory;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ProductInventory>
 */
class ProductInventoryFactory extends Factory
{
    protected $model = ProductInventory::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $status = [ProductInventory::STATUS_ACTIVE, ProductInventory::STATUS_INACTIVE, ProductInventory::STATUS_OUT_OF_STOCK, ProductInventory::STATUS_DRAFT];
        $availability_status = [ProductInventory::TILL_STOCK_LAST, ProductInventory::REGULAR_AVAILABLE];

        
        return [
            'user_id' => 2,
            'company_id' => 1,
            'title' => $this->faker->name(),
            'description' => $this->faker->text(),
            'model' =>  $this->faker->name(),
            'gst_percentage' => $this->faker->randomNumber(2),
            'hsn' => $this->faker->randomNumber(4),
            'upc' => $this->faker->randomNumber(4),
            'isbn' => $this->faker->randomNumber(4),
            'mpin' => $this->faker->randomNumber(4),
            'status' => $this->faker->randomElement($status),
            'availability_status' => $this->faker->randomElement($availability_status),
            'product_category' => 1,
            'product_subcategory' => 1
        ];
    }
}
