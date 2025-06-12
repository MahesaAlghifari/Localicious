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
        Schema::create('restaurant_payment_accounts', function (Blueprint $table) {
            $table->id();
            // Relasi ke restoran
            $table->foreignId('restaurant_id')
                  ->constrained('restaurants')
                  ->cascadeOnDelete();
            // Tipe akun (virtual_account atau ewallet)
            $table->enum('account_type', ['virtual_account', 'ewallet']);
            // Provider pembayaran (misalnya: midtrans)
            $table->enum('payment_provider', ['midtrans']);
            // Nomor akun atau identifier di provider
            $table->string('account_number');
            // Status aktif
            $table->boolean('is_active')->default(true);
            $table->timestamps(); // created_at & updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('restaurant_payment_accounts');
    }
};
