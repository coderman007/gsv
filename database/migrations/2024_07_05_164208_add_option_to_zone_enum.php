<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('projects', function (Blueprint $table) {
            // Agregar 'Antioquia Cercana' al enum 'zone'
            $table->enum('zone', [
                'Medellin y Municipios Cercanos',
                'Antioquia Cercana',
                'Antioquia Lejana',
                'Caribe',
                'Urabá',
                'Centro',
                'Valle'
            ])->default('Medellin y Municipios Cercanos')->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // No necesitamos una reversión específica para este cambio
    }
};
