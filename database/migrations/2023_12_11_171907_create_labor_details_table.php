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
        Schema::create('labor_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('labor_id');
            $table->unsignedBigInteger('job_position_id');
            $table->integer('quantity');
            $table->decimal('subtotal', 10, 2); // Calculado automáticamente
            $table->timestamps();

            $table->foreign('labor_id')->references('id')->on('labors')->cascadeOnDelete();
            $table->foreign('job_position_id')->references('id')->on('job_positions')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('labor_details');
    }
};
