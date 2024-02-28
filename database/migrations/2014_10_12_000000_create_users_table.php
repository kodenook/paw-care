<?php

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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('first_name', 20);
            $table->string('last_name', 20);
            $table->string('email');
            $table->string('phone', 17);
            $table->string('password')->nullable();
            $table->rememberToken();
            $table->timestamps();

            $table->index(['first_name', 'last_name'], 'full_name_index');
            $table->unique('email', 'email_unique');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
