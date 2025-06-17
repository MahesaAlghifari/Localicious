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

            // Kolom jam buka/tutup per hari (pakai tipe 'time', nullable)
            $table->time('mon_open')->nullable();
            $table->time('mon_close')->nullable();
            $table->time('tue_open')->nullable();
            $table->time('tue_close')->nullable();
            $table->time('wed_open')->nullable();
            $table->time('wed_close')->nullable();
            $table->time('thu_open')->nullable();
            $table->time('thu_close')->nullable();
            $table->time('fri_open')->nullable();
            $table->time('fri_close')->nullable();
            $table->time('sat_open')->nullable();
            $table->time('sat_close')->nullable();
            $table->time('sun_open')->nullable();
            $table->time('sun_close')->nullable();

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
