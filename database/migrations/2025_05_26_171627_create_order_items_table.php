<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('order_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')
                ->nullable()  // kalau ingin fleksibel
                ->constrained('orders')
                ->nullOnDelete(); // atau ->cascadeOnDelete()
            // hanya men-refer ke menu
            $table->foreignId('menu_id')
                ->constrained('menus')
                ->cascadeOnDelete();

            $table->unsignedInteger('quantity')->default(1);

            // harga yang disalin dari Menu saat item dibuat
            $table->decimal('unit_price', 12, 2);
            $table->decimal('subtotal',   12, 2);   // unit_price * quantity

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('order_items');
    }
};
