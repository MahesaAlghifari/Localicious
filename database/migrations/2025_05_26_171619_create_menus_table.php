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
        Schema::create('menus', function (Blueprint $table) {
            $table->id();
            $table->foreignId('restaurant_id')->constrained()->cascadeOnDelete();

            $table->string('item_name');
            $table->text('description')->nullable();

            $table->decimal('price', 10, 2);

            // Kolom opsional ➜ nullable
            $table->enum('size', ['small', 'medium', 'large'])->nullable();
            $table->enum('spice_level', ['low', 'medium', 'high'])->nullable();
            $table->enum('category', ['appetizer', 'main', 'dessert', 'drink'])->nullable();

            $table->integer('quantity')->default(0);      // stok
            $table->boolean('is_active')->default(true);
            $table->string('image_url')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('menus');
    }
};
