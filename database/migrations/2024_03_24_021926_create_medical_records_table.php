<?php

use App\Models\AppointmentScheduling;
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
        Schema::create('medical_records', function (Blueprint $table) {
            $table->id();
            $table->text('prescription');
            $table->decimal('weight', unsigned: true);
            $table->string('attachments', 1000);
            $table->timestamps();

            $table->foreignIdFor(AppointmentScheduling::class, 'appointment_id')->constrained('appointment_scheduling')->cascadeOnUpdate()->restrictOnDelete();
            $table->foreignIdFor(Pet::class, 'pet_id')->constrained()->cascadeOnUpdate()->restrictOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('medical_records');
    }
};
