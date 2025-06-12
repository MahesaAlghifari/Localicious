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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            // Relasi ke order
            $table->foreignId('order_id')
                  ->constrained('orders')
                  ->cascadeOnDelete();
            // Total yang dibayarkan
            $table->decimal('amount', 12, 2);
            // Metode pembayaran (e.g., 'cash', 'midtrans', 'ewallet')
            $table->string('method')->nullable();
            // Status pembayaran (e.g., 'pending', 'paid', 'failed')
            $table->enum('status', ['pending', 'paid', 'failed'])
                  ->default('pending');
            // ID virtual account atau reference jika ada
            $table->string('reference_id')->nullable();
            $table->timestamps(); // created_at & updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
