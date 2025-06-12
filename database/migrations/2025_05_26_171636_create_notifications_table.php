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
        Schema::create('notifications', function (Blueprint $table) {
            $table->id();
            // Relasi ke restoran
            $table->foreignId('restaurant_id')
                  ->constrained('restaurants')
                  ->cascadeOnDelete();
            // Judul notifikasi
            $table->string('title');
            // Isi pesan notifikasi
            $table->text('message');
            // Tipe/kanal notifikasi (misal: 'in_app', 'email', dsb.)
            $table->string('type')->default('in_app');
            // Status sudah dibaca atau belum
            $table->boolean('is_read')->default(false);
            $table->timestamps(); // created_at & updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notifications');
    }
};
