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
        Schema::create('transport_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('transport_id');
            $table->string('transport_name');
            $table->string('transport_description')->nullable();
            $table->decimal('transportation_fare', 10, 2)->nullable();
            $table->decimal('quantity');
            $table->decimal('daily_unit_cost', 10, 2);
            $table->decimal('subtotal', 10, 2); // Calculado automáticamente
            $table->timestamps();

            $table->foreign('transport_id')->references('id')->on('transports')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transport_details');
    }
};
