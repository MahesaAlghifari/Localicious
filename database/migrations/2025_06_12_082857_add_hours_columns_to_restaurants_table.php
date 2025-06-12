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
    Schema::table('restaurants', function (Blueprint $table) {
        $table->string('province')->after('address');
        $table->string('city')->after('province');
        $table->string('hours_mon')->nullable()->after('city');
        $table->string('hours_tue')->nullable()->after('hours_mon');
        $table->string('hours_wed')->nullable()->after('hours_tue');
        $table->string('hours_thu')->nullable()->after('hours_wed');
        $table->string('hours_fri')->nullable()->after('hours_thu');
        $table->string('hours_sat')->nullable()->after('hours_fri');
        $table->string('hours_sun')->nullable()->after('hours_sat');
        $table->string('image_url')->nullable()->after('hours_sun');
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('restaurants', function (Blueprint $table) {
            //
        });
    }
};
