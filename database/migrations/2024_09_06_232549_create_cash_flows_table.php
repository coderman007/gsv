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
        Schema::create('cash_flows', function (Blueprint $table) {
            $table->id();
            $table->foreignId('quotation_id')->constrained()->onDelete('cascade')->index();

            // Variables del proyecto
            $table->decimal('power_output', 10, 2); // Potencia (P)
            $table->decimal('capex', 15, 2); // CAPEX (Inversión)
            $table->decimal('energy_cost', 10, 2); // Costo de la energía (CE)
            $table->decimal('energy_generated_annual', 15, 2); // Energía Anual Generada (EAG)
            $table->decimal('energy_generated_monthly', 15, 2); // Energía Mensual Generada (EMG)

            // Variables adicionales
            $table->decimal('mgei', 8, 4)->nullable(); // Mitigación de GEI
            $table->decimal('ca', 8, 4)->nullable();   // Compensación Arbórea

            // Ingresos y egresos almacenados en JSON
            $table->json('income_autoconsumption')->nullable(); // Ingresos por autoconsumo (AA) - Año 1 a 25
            $table->json('tax_discount')->nullable(); // Descuento de renta (DR) - Año 1 a 25
            $table->json('accelerated_depreciation')->nullable(); // Depreciación Acelerada (DA) - Año 1 a 25
            $table->json('opex')->nullable(); // OPEX (Costos operativos) - Año 1 a 25
            $table->json('maintenance_cost')->nullable(); // Costos de mantenimiento (CMA) - Año 1 a 25
            $table->json('cash_flow')->nullable(); // Caja libre - Año 1 a 25
            $table->json('accumulated_cash_flow')->nullable(); // Flujo acumulado - Año 1 a 25
            $table->decimal('internal_rate_of_return', 8, 1)->nullable();
            $table->decimal('payback_time')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cash_flows');
    }
};
