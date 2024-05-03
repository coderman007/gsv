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
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('project_category_id');

            $table->enum('zone', [
                'Zona Caribe',
                'Zona Andina',
                'Zona Pacífica',
                'Zona de la Orinoquía',
                'Zona de la Amazonía'
            ])->default('Zona Andina');
            $table->double('kilowatts_to_provide')->default(0);

            // Nuevos campos para las comisiones, margen, descuento, y costo total
            $table->decimal('internal_commissions', 5)->nullable();
            $table->decimal('external_commissions', 5)->nullable();
            $table->decimal('margin', 5)->nullable();
            $table->decimal('discount', 5)->nullable();
            $table->decimal('total', 20)->nullable();
            $table->decimal('sale_value', 20)->nullable(); // Precio de venta del proyecto

            $table->enum('status', ['Activo', 'Inactivo'])->default('Activo');
            $table->timestamps();

            $table->foreign('project_category_id')->references('id')->on('project_categories')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('projects');
    }
};
