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
        Schema::create('restaurant_polygons', function (Blueprint $table) {
            $table->id();
            // Hubungan ke restoran yang memiliki area geofence ini
            $table->foreignId('restaurant_id')
                  ->constrained('restaurants')
                  ->cascadeOnDelete();
            // Nama poligon (misal: "Dining Area", "Pickup Zone", dll.)
            $table->string('name')->nullable();
            // Koordinat titik-titik poligon dalam format GeoJSON atau array koordinat
            $table->json('coordinates');
            $table->timestamps(); // created_at & updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('restaurant_polygons');
    }
};
