<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('project_category_id');

            $table->double('power_output', 20, 2)->default(0);
            $table->enum('zone', [
                'Medellin y Municipios Cercanos',
                'Antioquia Lejana',
                'Caribe',
                'Urabá',
                'Centro',
                'Valle'
            ])->default('Medellin y Municipios Cercanos');
            $table->decimal('hand_tool_cost', 20)->default(0);
            $table->decimal('required_area', 10)->default(0);
            $table->decimal('total_labor_cost', 20)->default(0);
            $table->decimal('total_tool_cost', 20)->default(0);
            $table->decimal('total_material_cost', 20)->default(0);
            $table->decimal('total_transport_cost', 20)->default(0);
            $table->decimal('total_additional_cost', 20)->default(0);
            $table->decimal('raw_value', 20)->nullable();
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
