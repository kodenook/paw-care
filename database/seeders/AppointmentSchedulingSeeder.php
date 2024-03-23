<?php

namespace Database\Seeders;

use App\Models\AppointmentScheduling;
use Illuminate\Database\Seeder;

class AppointmentSchedulingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if (@env('APP_ENV') !== 'production') {
            AppointmentScheduling::factory(5)->create();
            AppointmentScheduling::factory(5)->deleted()->create();
        }
    }
}
