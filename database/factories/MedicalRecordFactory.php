<?php

namespace Database\Factories;

use App\Models\AppointmentScheduling;
use App\Models\Pet;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\MedicalRecord>
 */
class MedicalRecordFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $totalPets = Pet::get('id')->count();
        $totalAppointments = AppointmentScheduling::get('id')->toArray();
        $appointmentId = fake()->numberBetween(1, $totalAppointments);
        $petId = fake()->numberBetween(1, $totalPets);

        return [
            'prescription' => fake()->paragraphs(2, true),
            'weight' => fake()->numerify('#.##'),
            'attachments' => '',
            'pet_id' => $petId,
            'appointment_id' => $appointmentId,
        ];
    }
}
