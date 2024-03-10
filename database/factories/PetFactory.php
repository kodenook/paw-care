<?php

namespace Database\Factories;

use App\Models\Specie;
use App\Models\User;
use Database\Providers\AnimalProvider;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Pet>
 */
class PetFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        fake()->addProvider(new AnimalProvider(fake()));

        $totalUsers = User::get('id')->count();
        $totalSpecies = Specie::get('id')->toArray();
        $specie = fake()->numberBetween(1, count($totalSpecies) - 1);

        return [
            'name' => fake()->unique()->nameAnimal(),
            'user_id' => fake()->numberBetween(1, $totalUsers),
            'specie_id' => $totalSpecies[$specie]['id'],
        ];
    }
}
