<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $phone = str_split(fake()->e164PhoneNumber());
        unset($phone[0]);
        $phone = implode($phone);

        return [
            'first_name' => fake()->firstName(),
            'last_name' => fake()->lastName(),
            'email' => fake()->unique()->freeEmail(),
            'phone' => $phone,
            'remember_token' => Str::random(10),
        ];
    }

    /**
     * Indicate that the model's password should be password.
     */
    public function password(): static
    {
        return $this->state(fn (array $attributes) => [
            'password' => static::$password ??= 'password',
        ]);
    }
}
