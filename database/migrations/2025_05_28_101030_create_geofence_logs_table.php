<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('geofence_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')
                  ->constrained()
                  ->cascadeOnDelete();
            $table->foreignId('polygon_id')
                  ->constrained('restaurant_polygons')
                  ->cascadeOnDelete();
            $table->decimal('raw_lat', 10, 6);
            $table->decimal('raw_lng', 10, 6);
            $table->decimal('filt_lat', 10, 6);
            $table->decimal('filt_lng', 10, 6);
            $table->float('speed');
            $table->integer('anomaly_count');
            $table->boolean('inside');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('geofence_logs');
    }
};
