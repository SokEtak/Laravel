<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Student>
 */
class StudentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'first_name' => $this->faker->firstName(),
            'last_name' => $this->faker->lastName(),
            'gender' => $this->faker->randomElement(['male','female']),
            'dob' => $this->faker->dateTimeBetween('-20 years', '-10 years'),
            'grade' => $this->faker->randomElement(['1A', '2B', '3C', '4D', '5E']),
            'address' => $this->faker->address(),
            'tenant_id' => $this->faker->numberBetween(1, 2),
            'created_at' => $this->faker->dateTimeBetween('-1 month', 'now'),
            'updated_at' => now(),
        ];
    }
}
