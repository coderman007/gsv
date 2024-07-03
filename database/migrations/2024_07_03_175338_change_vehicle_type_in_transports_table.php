<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('transports', function (Blueprint $table) {
            // Cambiar el tipo de la columna vehicle_type de enum a string
            $table->string('vehicle_type')->change();
        });
    }

    public function down(): void
    {
        Schema::table('transports', function (Blueprint $table) {
            // Cambiar el tipo de la columna vehicle_type de vuelta a enum
            $table->enum('vehicle_type', ['Motocicleta', 'Automóvil', 'Camión', 'Autobús', 'Van', 'Otro'])->change();
        });
    }
};
