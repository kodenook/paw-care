<?php

namespace Database\Factories;

use Database\Providers\AnimalProvider;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Specie>
 */
class SpecieFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        fake()->addProvider(new AnimalProvider(fake()));

        return [
            'name' => fake()->unique()->specieAnimal(),
        ];
    }
}
