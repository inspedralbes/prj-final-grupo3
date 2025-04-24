<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
  /**
   * Run the migrations.
   */
  public function up(): void
  {
    Schema::create('travel_activities', function (Blueprint $table) {
      $table->id();
      $table->foreignId('travel_day_id')->constrained('travel_days')->onDelete('cascade');
      $table->string('name');
      $table->text('description');
      $table->string('price')->nullable();
      $table->time('start_time');
      $table->time('end_time');
      $table->integer('order');
      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('travel_activities');
  }
};
