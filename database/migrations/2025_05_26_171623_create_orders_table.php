<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
        
            // 🔗 Relasi ke pengguna (customer)
            $table->foreignId('user_id')
                ->constrained('users')          // pastikan nama tabel relasi adalah 'users'
                ->cascadeOnDelete();

            // 🔗 Relasi ke restoran
            $table->foreignId('restaurant_id')
                ->constrained('restaurants')    // pastikan nama tabel relasi adalah 'restaurants'
                ->cascadeOnDelete();

            // 📌 Status pesanan
            $table->enum('status', ['pending', 'processing', 'completed', 'cancelled'])
                ->default('pending')
                ->index();

            // 💰 Total keseluruhan tagihan dari order_items
            $table->decimal('total_amount', 12, 2)
                ->default(0)
                ->comment('Total harga semua item');

            // 📅 Jadwal pengambilan/pengiriman
            $table->timestamp('scheduled_at')
                ->nullable()
                ->comment('Waktu penjadwalan pesanan');

            // 💳 Metode pembayaran
            $table->string('payment_method')
                ->nullable();

            // 🏷️ ID dari Midtrans
            $table->string('midtrans_order_id')
                ->nullable()
                ->unique()
                ->comment('Digunakan untuk tracking pembayaran');

            // 🗒️ Catatan tambahan dari pelanggan
            $table->text('notes')
                ->nullable();

            // 🕒 Timestamp Laravel
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
