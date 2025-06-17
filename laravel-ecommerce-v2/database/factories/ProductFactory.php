<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Discount;
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
            'product_name' => $this->faker->name(),
            'product_description' => $this->faker->text(),
            'SKU' => $this->faker->unique()->text(5),
            'price' => $this->faker->numberBetween(1, 1000),
            'discount_id' => $this->faker->numberBetween(1, 1),
            'inventory_id' => $this->faker->numberBetween(1, 1),
            'category_id' => $this->faker->numberBetween(1, 2),

        ];
    }
}
