<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('macro_economic_variables', function (Blueprint $table) {
            $table->id();
            $table->string('name');  // Nombre de la variable (e.g., IPC, IR, IACE, PESF, CMA)
            $table->decimal('value', 10, 1);  // Valor de la variable (e.g., 0.05 para 5%)
            $table->string('unit')->nullable();  // Unidad de medida (e.g., %, COP/kWh)
            $table->text('description')->nullable();  // Descripción adicional
            $table->date('effective_date');  // Fecha de efectividad
            $table->timestamps();  // Timestamps para created_at y updated_at
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('macro_economic_variables');
    }
};
