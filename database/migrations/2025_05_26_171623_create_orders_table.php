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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            // Relasi ke customer (pembeli)
            $table->foreignId('customer_id')
                  ->constrained('customers')
                  ->cascadeOnDelete();
            // Relasi ke restoran
            $table->foreignId('restaurant_id')
                  ->constrained('restaurants')
                  ->cascadeOnDelete();
            // Status pesanan: pending, processing, completed, cancelled
            $table->enum('status', ['pending', 'processing', 'completed', 'cancelled'])
                  ->default('pending');
            // Total harga
            $table->decimal('total_amount', 12, 2);
            // Waktu pickup atau delivery
            $table->timestamp('scheduled_at')->nullable();
            // Metode pembayaran (contoh: 'cash', 'midtrans', etc)
            $table->string('payment_method')->nullable();
            // Catatan tambahan
            $table->text('notes')->nullable();
            $table->timestamps(); // created_at & updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
