<?php

namespace Database\Factories;
use App\Models\ProductInventory;
use App\Models\ProductVariation;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ProductVariation>
 */
class ProductVariationFactory extends Factory
{
    protected $model = ProductVariation::class;
    
    protected $productInventory;

    public function __construct($productInventory = null)
    {
        $this->productInventory = $productInventory;
        parent::__construct();
    }
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // Define possible colors and sizes
        $colors = ['red', 'blue', 'green', 'yellow', 'black', 'white'];
        $sizes = ['small', 'medium', 'large', 'XL', 'XXL'];
        $status = [ProductVariation::STATUS_ACTIVE, ProductVariation::STATUS_INACTIVE, ProductVariation::STATUS_OUT_OF_STOCK, ProductVariation::STATUS_DRAFT];
        $availability_status = [ProductVariation::TILL_STOCK_LAST, ProductVariation::REGULAR_AVAILABLE];

        $product_id = $this->productInventory ? $this->productInventory->id : 1;
        $title = $this->faker->name();
        $p_id = generateProductID($title, $product_id);
        return [
            'product_id' => $product_id,
            'product_slug_id' => $p_id,
            'slug' => generateSlug($title, $p_id),
            'company_id' => 1,
            'title' => $title,
            'description' =>  $this->faker->paragraph,
            'sku' => generateSKU($title, $this->faker->name()),
            'length' => 10,
            'width' => 10,
            'height' => 10,
            'dimension_class' => 'cm',
            'weight' => 10,
            'weight_class' => 'kg',
            'volumetric_weight' => 10,
            'package_length' => 10,
            'package_width' => 10,
            'package_height' => 10,
            'package_dimension_class' => 'cm',
            'package_weight' => 10,
            'package_weight_class' => 'kg',
            'price_before_tax' => $this->faker->numberBetween(0, 1000),
            'price_after_tax' => $this->faker->numberBetween(0, 1000),
            'stock' => $this->faker->numberBetween(0, 100),
            'status' => $this->faker->randomElement($status),
            'availability_status' => $this->faker->randomElement($availability_status),
            'dropship_rate' => 10,
            'potential_mrp' => 120,
            'tier_rate' => [
                '1' => 100,
                '2' => 90,
                '3' => 80,
                '4' => 70,
                '5' => 60,
            ],
            'tier_shipping_rate' => [
                '1' => 10,
                '2' => 9,
                '3' => 8,
                '4' => 7,
                '5' => 6,
            ],
            // Add random color and size
            'color' => $this->faker->randomElement($colors),
            'size' => $this->faker->randomElement($sizes),
        ];
    }
}
