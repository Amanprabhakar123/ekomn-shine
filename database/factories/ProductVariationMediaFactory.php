<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ProductVariationMedia>
 */
class ProductVariationMediaFactory extends Factory
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
            'product_id' =>  $this->productInventory ? $this->productInventory->id : 1,
            'product_variation_id' => $this->faker->numberBetween(1, 10),
            'media_type' => $this->faker->randomElement([0, 1]),
            'file_path' => $this->faker->imageUrl(),
            'is_master' => $this->faker->boolean(),
            'desc' => $this->faker->sentence(),
            'is_active' => $this->faker->boolean(),
        ];
    }
}
