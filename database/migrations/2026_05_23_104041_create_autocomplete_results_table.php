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
        Schema::create('autocomplete_results', function (Blueprint $table) {

    $table->id();

    $table->foreignId('search_id')
      ->constrained('autocomplete_searches')
      ->cascadeOnDelete();

    $table->string('place_id')->nullable();

    $table->text('display_name');

    $table->string('city')->nullable();

    $table->decimal('lat', 10, 7);

    $table->decimal('lon', 10, 7);

    $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('autocomplete_results');
    }
};
