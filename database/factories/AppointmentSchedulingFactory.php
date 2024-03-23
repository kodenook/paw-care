<?php

namespace Database\Factories;

use Database\Providers\AnimalProvider;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\AppointmentScheduling>
 */
class AppointmentSchedulingFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        fake()->addProvider(new AnimalProvider(fake()));

        $phone = str_split(fake()->e164PhoneNumber());
        unset($phone[0]);
        $phone = implode($phone);

        $date = fake()->dateTimeBetween('-1 week', '+2 week');
        $hours = [
            '9:00', '9:30', '10:00', '10:30', '11:00',
            '11:30', '12:00', '12:30', '13:00', '13:30',
            '14:00', '14:30', '15:00', '15:30', '16:00', '16:30',
            '17:00', '17:30',
        ];

        return [
            'date' => $date,
            'time' => fake()->randomElement($hours),
            'pet_name' => fake()->nameAnimal(),
            'owner_name' => fake()->name(),
            'owner_email' => fake()->unique()->freeEmail(),
            'owner_phone' => $phone,
            'reason' => fake()->paragraphs(2, true),
            'pet_id' => null,
        ];
    }

    /**
     * Indicate that the model's deleted_at should not be null.
     */
    public function deleted(): static
    {
        return $this->state(fn (array $attributes) => [
            'deleted_at' => fake()->dateTimeBetween('-3 day', $attributes['date']),
        ]);
    }
}
