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
        Schema::create('restaurants', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('address');
            $table->string('province');
            $table->string('city');

            // Kolom jam operasional per hari
            $table->string('hours_mon')->nullable();  // e.g. "09:00-18:00"
            $table->string('hours_tue')->nullable();
            $table->string('hours_wed')->nullable();
            $table->string('hours_thu')->nullable();
            $table->string('hours_fri')->nullable();
            $table->string('hours_sat')->nullable();
            $table->string('hours_sun')->nullable();

            // Path atau URL gambar
            $table->string('image_url')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('restaurants');
    }
};
