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
        Schema::create('geofencing_notifications', function (Blueprint $table) {
            $table->id();
            // Hubungan ke restoran terkait geofence
            $table->foreignId('restaurant_id')
                  ->constrained('restaurants')
                  ->cascadeOnDelete();
            // (Opsional) Hubungan ke pelanggan yang memicu notifikasi
            $table->foreignId('customer_id')
                  ->nullable()
                  ->constrained('customers')
                  ->nullOnDelete();
            // (Opsional) Hubungan ke poligon geofence yang dipakai
            $table->foreignId('polygon_id')
                  ->nullable()
                  ->constrained('restaurant_polygons')
                  ->nullOnDelete();
            // Jenis event geofence: masuk, keluar, atau pelanggaran
            $table->enum('event_type', ['enter', 'exit', 'breach'])
                  ->default('enter');
            // Waktu notifikasi dikirim
            $table->timestamp('notified_at')->nullable();
            // Data tambahan (misal payload dari sensor atau API)
            $table->json('payload')->nullable();
            $table->timestamps(); // created_at & updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('geofencing_notifications');
    }
};
