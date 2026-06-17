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
        Schema::create('bookings', function (Blueprint $table) {
    $table->id();

    // user info
    $table->string('name');
    $table->string('email');
    $table->string('phone');
    $table->integer('passengers');

    // ride info
    $table->string('pickup_address');
    $table->string('dropoff_address');

    // schedule
    $table->date('travel_date');
    $table->time('travel_time');

    $table->timestamps();
});
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};
