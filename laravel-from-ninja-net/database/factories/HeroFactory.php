<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Hero>
 */
class HeroFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'damage' => $this->faker->numberBetween(1, 100),
            'health' => $this->faker->numberBetween(1, 100),
            'armor' => $this->faker->numberBetween(1, 100),
        ];
    }
}
