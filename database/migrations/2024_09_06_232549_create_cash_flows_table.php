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

            $table->decimal('mgei', 8, 4)->nullable(); // Mitigación de GEI
            $table->decimal('ca', 8, 4)->nullable();   // Compensación Arbórea

            // Ingresos y egresos
            $table->decimal('income_autoconsumption', 15, 2); // Ingresos por autoconsumo
            $table->decimal('tax_discount', 15, 2); // Descuento de renta (DR)
            $table->decimal('accelerated_depreciation', 15, 2); // Depreciación Acelerada (DA)

            $table->decimal('opex', 15, 2); // OPEX (Costos operativos)
            $table->decimal('maintenance_cost', 15, 2); // Costos de mantenimiento (CMA)

            // Caja libre y flujo acumulado
            $table->decimal('cash_flow', 30, 2); // Caja libre
            $table->decimal('accumulated_cash_flow', 30, 2); // Flujo acumulado

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
