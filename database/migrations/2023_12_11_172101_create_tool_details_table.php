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
        Schema::create('tool_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('tool_id');
            $table->string('tool_name');
            $table->string('tool_description');
            $table->integer('quantity');
            $table->decimal('daily_unit_cost', 10, 2);
            $table->decimal('subtotal', 10, 2); // Calculado automáticamente
            $table->timestamps();

            $table->foreign('tool_id')->references('id')->on('tools')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tool_details');
    }
};
