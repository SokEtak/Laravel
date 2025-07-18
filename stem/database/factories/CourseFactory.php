<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Courses>
 */
class CourseFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'tenant_id'=>$this->faker->numberBetween(1,2),
            'teacher_id'=>$this->faker->numberBetween(1,100),
            'subject_id'=>$this->faker->numberBetween(1,2),
            'name'=>$this->faker->word(),
            'description'=>$this->faker->sentence(),
            'level'=>$this->faker->randomElement(['123','go','iq','exp']),
        ];
    }
}
