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
        Schema::create('transports', function (Blueprint $table) {
            $table->id();
            // Campo para el tipo de vehículo
            $table->enum('vehicle_type', ['Motocicleta', 'Automóvil', 'Camión', 'Autobús', 'Van', 'Otro']);
            // Campo para el costo diario de uso
            $table->decimal('cost_per_day', 10);
            $table->unsignedSmallInteger('capacity')->nullable();
            $table->string('fuel_type')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transports');
    }
};
