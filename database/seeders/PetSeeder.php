<?php

namespace Database\Seeders;

use App\Models\Pet;
use Illuminate\Database\Seeder;

class PetSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if (@env('APP_ENV') !== 'production') {
            Pet::factory(10)->create();
        }
    }
}
