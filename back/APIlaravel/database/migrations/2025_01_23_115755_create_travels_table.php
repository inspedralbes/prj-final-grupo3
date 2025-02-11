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
        Schema::create('travels', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_country');
            $table->foreign('id_country')->references('id')->on('countries')->onDelete('cascade');
            $table->unsignedBigInteger('id_user');
            $table->foreign('id_user')->references('id')->on('users')->onDelete('cascade');
            $table->unsignedBigInteger('id_type');
            $table->foreign('id_type')->references('id')->on('type')->onDelete('cascade');
            $table->unsignedBigInteger('id_budget');
            $table->foreign('id_budget')->references('id')->on('budget')->onDelete('cascade');
            $table->unsignedBigInteger('id_movility');
            $table->foreign('id_movility')->references('id')->on('movilities')->onDelete('cascade');
            $table->date('date_init');
            $table->date('date_end');
            $table->integer('qunt_date')->nullable();
            $table->text('description');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('travels');
    }
};
