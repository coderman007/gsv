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
            $table->enum('vehicle_type', ['motocicleta', 'automóvil', 'camión', 'autobús', 'van', 'otro']);
            // Campo para el costo de la gasolina por kilómetro
            $table->decimal('gasoline_cost_per_km');
            // Campo para el costo diario de uso
            $table->decimal('cost_per_day', 10);
            // Campo para el valor de peajes (por defecto cero para motocicletas)
            $table->decimal('toll_cost')->default(0);
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
