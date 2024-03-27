<?php

namespace Database\Seeders;

use App\Models\MedicalRecord;
use Illuminate\Database\Seeder;

class MedicalRecordSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if (@env('APP_ENV') !== 'production') {
            MedicalRecord::factory(10)->create();
        }
    }
}
