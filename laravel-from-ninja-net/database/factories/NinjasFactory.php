<?php
namespace Database\Factories;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Ninjas>
 */
use App\Models\Dojo;
class NinjasFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->name(10),
            'damage' => $this->faker->numberBetween(1, 100),
            'skill' => $this->faker->word(),
            'dojo_id' => Dojo::inRandomOrder()->first()->id, // Create a new Dojo instance
        ];
    }
}
