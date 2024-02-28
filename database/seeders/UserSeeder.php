<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::factory()->password()->create([
            'first_name' => 'admin',
            'last_name' => '',
            'email' => 'admin@pawcare.com',
            'phone' => '',
        ]);

        if (@env('APP_ENV') !== 'production') {
            User::factory(5)->create();
            User::factory(4)->password()->create();
        }
    }
}
