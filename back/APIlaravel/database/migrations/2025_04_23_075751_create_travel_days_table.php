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
    Schema::create('travel_days', function (Blueprint $table) {
      $table->id();
      $table->foreignId('travel_plan_id')->constrained('travel_plans')->onDelete('cascade');
      $table->string('date');
      $table->string('accommodation')->nullable();
      $table->integer('day_number');
      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('travel_days');
  }
};
