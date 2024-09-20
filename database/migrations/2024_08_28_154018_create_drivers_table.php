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
        Schema::create('drivers', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('no_whatsapp');
            $table->string('plat_number');
            $table->string('password');
            $table->string('saldo')->default(0);
            $table->string('role')->default('driver');
            $table->string('type_vehicle');
            $table->string('vehicle_name');
            $table->string('location');
            $table->enum('is_limited', ['false', 'true'])->default('false');
            $table->enum('is_status', ['waiting', 'accept', 'block', 'cancel'])->default('waiting');
            $table->enum('is_active', ['false', 'true'])->default('false');
            $table->string('latitude')->nullable();
            $table->string('longitude')->nullable();
            $table->string('photo_profile');
            $table->string('fcm_token')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('drivers');
    }
};
