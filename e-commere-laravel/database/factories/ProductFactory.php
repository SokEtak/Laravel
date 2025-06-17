<?php

namespace Database\Factories;

use App\Models\Discount;
use App\Models\ProductCategory;
use Illuminate\Database\Eloquent\Factories\Factory;
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'SKU' => $this->faker->unique()->bothify('SKU-####'),
            'category_id' => ProductCategory::inRandomOrder()->first()?->id,
            'discount_id' => Discount::factory(),
            'price' => $this->faker->randomFloat(2, 5, 500), // price between 5.00 and 500.00
        ];
    }
}
