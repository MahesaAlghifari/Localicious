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
        Schema::create('midtrans_transactions', function (Blueprint $table) {
            $table->id();
            // Relasi ke tabel payments
            $table->foreignId('payment_id')
                  ->constrained('payments')
                  ->cascadeOnDelete();
            // Relasi ke tabel restaurant_payment_accounts
            $table->foreignId('payment_account_id')
                  ->constrained('restaurant_payment_accounts')
                  ->cascadeOnDelete();
            // Order ID dari Midtrans
            $table->string('midtrans_order_id');
            // Transaction ID dari Midtrans
            $table->string('transaction_id');
            // Virtual Account Number jika ada
            $table->string('va_number')->nullable();
            // URL pembayaran (jika menggunakan redirect)
            $table->string('payment_url')->nullable();
            // QR string (misal untuk QRIS)
            $table->text('qr_string')->nullable();
            // Fraud status (accept, challenge, deny)
            $table->string('fraud_status')->nullable();
            // URL untuk cek status transaksi
            $table->string('status_url')->nullable();
            $table->timestamps(); // created_at & updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('midtrans_transactions');
    }
};
