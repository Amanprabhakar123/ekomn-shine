<?php

namespace Database\Factories;
use App\Models\ProductVariation;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ProductVariation>
 */
class ProductVariationFactory extends Factory
{
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
        return [
            'product_id' => $this->productInventory ? $this->productInventory->id : 1,
            'company_id' => $this->productInventory ? $this->productInventory->company_id : 1,
            'title' => $this->productInventory ? $this->productInventory->title : $this->faker->sentence,
            'description' => $this->productInventory ? $this->productInventory->description : $this->faker->paragraph,
            'sku' => generateSKU($this->faker->name(), $this->faker->name()),
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
            'price_before_tax' => 100,
            'price_after_tax' => 110,
            'stock' => 10,
            'status' => ProductVariation::STATUS_ACTIVE,
            'availability_status' => ProductVariation::REGULAR_AVAILABLE,
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
            'color' => 'red',
            'size' => 'medium',
        ];
    }
}
