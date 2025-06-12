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
        Schema::create('order_items', function (Blueprint $table) {
            $table->id();
            // Relasi ke order
            $table->foreignId('order_id')
                  ->constrained('orders')
                  ->cascadeOnDelete();
            // Relasi ke menu item
            $table->foreignId('menu_id')
                  ->constrained('menus')
                  ->cascadeOnDelete();
            // Kuantitas item yang dipesan
            $table->integer('quantity')->default(1);
            // Harga satuan pada saat pemesanan
            $table->decimal('unit_price', 12, 2);
            // Subtotal = quantity * unit_price (bisa dihitung di aplikasi)
            $table->decimal('subtotal', 12, 2);
            $table->timestamps(); // created_at & updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_items');
    }
};
