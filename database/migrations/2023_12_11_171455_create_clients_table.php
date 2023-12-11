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
        Schema::create('clients', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('address'); //Este campo me permitirá conocer el nivel de radiación de la zona
            $table->string('phone');
            $table->string('email');
            $table->decimal('average_energy_consumption', 10, 2);  //Este campo me permitirá conocer la cantidad de Kwh a proveer
            $table->decimal('solar_radiation_level', 2, 2); //Este campo me permitirá conocer el nivel de radiación de la zona con base en la ubicación.
            $table->decimal('roof_dimensions_length', 8, 2); //Permite almacenar la longitud de la cubierta
            $table->decimal('roof_dimensions_width', 8, 2); //Permite almacenar la anchura de la cubierta
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clients');
    }
};
