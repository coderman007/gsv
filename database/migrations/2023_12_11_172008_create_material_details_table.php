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
        Schema::create('material_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('material_id');
            $table->string('material_name');
            $table->string('material_description');
            $table->integer('quantity');
            $table->decimal('daily_unit_cost', 10, 2);
            $table->decimal('subtotal', 10, 2); // Calculado automáticamente
            $table->timestamps();

            $table->foreign('material_id')->references('id')->on('materials')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('material_details');
    }
};
