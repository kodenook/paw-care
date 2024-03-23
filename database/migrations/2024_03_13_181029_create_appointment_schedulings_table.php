<?php

use App\Models\Pet;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('appointment_scheduling', function (Blueprint $table) {
            $table->id();
            $table->date('date');
            $table->enum('time', [
                '9:00' => '9:00',
                '9:30' => '9:30',
                '10:00' => '10:00',
                '10:30' => '10:30',
                '11:00' => '11:00',
                '11:30' => '11:30',
                '12:00' => '12:00',
                '12:30' => '12:30',
                '13:00' => '13:00',
                '13:30' => '13:30',
                '14:00' => '14:00',
                '14:30' => '14:30',
                '15:00' => '15:00',
                '15:30' => '15:30',
                '16:00' => '16:00',
                '16:30' => '16:30',
                '17:00' => '17:00',
                '17:30' => '17:30',
            ]);
            $table->string('pet_name', 50);
            $table->string('owner_name', 50);
            $table->string('owner_email');
            $table->string('owner_phone', 17);
            $table->string('reason', 1000);
            $table->timestamps();
            $table->softDeletes();

            $table->foreignIdFor(Pet::class, 'pet_id')->nullable()->constrained()->cascadeOnUpdate()->restrictOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('appointment_scheduling');
    }
};
