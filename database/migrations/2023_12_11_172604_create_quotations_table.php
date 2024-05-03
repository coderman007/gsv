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
        Schema::create('quotations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('project_id');
            $table->unsignedBigInteger('client_id');
            $table->date('quotation_date');
            $table->unsignedSmallInteger('validity_period');
            $table->enum('transformer', ['Trifásico', 'Monofásico']);
            $table->decimal('average_energy_consumption', 8, 2);
            $table->decimal('solar_radiation_level', 8, 2);
            $table->decimal('roof_dimension', 8, 2);
            $table->decimal('total_cost_kilowatt');
            $table->decimal('subtotal', 20, 2);
            $table->decimal('total_quotation_amount', 20, 2);
            $table->enum('status', ['Generada', 'Ganada', 'Perdida'])->default('Generada');
            $table->timestamps();

            $table->foreign('project_id')->references('id')->on('projects')->cascadeOnDelete();
            $table->foreign('client_id')->references('id')->on('clients')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('quotations');
    }
};
