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
        Schema::create('travel', function (Blueprint $table) {
            $table->id();
            $table->foreign('id_country')->references('id')->on('country')->onDelete('cascade');
            $table->fereign('id_type')->references('id')->on('type')->onDelete('cascade');
            $table->foreign('id_budget')->references('id')->on('budget')->onDelete('cascade');
            $table->foreign('id_movility')->references('id')->on('movility')->onDelete('cascade');
            $table->string('qunt_date');
            $table->string('date_init');
            $table->string('date_end');
            $table->string('description');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('travel');
    }
};
