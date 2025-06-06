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
    Schema::create('travel_plans', function (Blueprint $table) {
      $table->id();
      $table->foreignId('travel_id')->constrained('travels')->onDelete('cascade');
      $table->string('title');
      $table->string('summary_day')->nullable();
      $table->string('total_price')->nullable();
      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('travel_plans');
  }
};
