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
       Schema::table('bookings', function (Blueprint $table) {

    // pickup
    $table->decimal('pickup_lat', 10, 7)->nullable();
    $table->decimal('pickup_lng', 10, 7)->nullable();

    $table->string('pickup_city')->nullable();
    $table->string('pickup_place_id')->nullable();

    // dropoff
    $table->decimal('dropoff_lat', 10, 7)->nullable();
    $table->decimal('dropoff_lng', 10, 7)->nullable();

    $table->string('dropoff_city')->nullable();
    $table->string('dropoff_place_id')->nullable();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
        });
    }
};
