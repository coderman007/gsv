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
            $table->string('consecutive')->nullable();
            $table->unsignedBigInteger('project_id');
            $table->unsignedBigInteger('client_id');
            $table->date('quotation_date');
            $table->unsignedSmallInteger('validity_period');
            $table->enum('transformer', ['Trifásico', 'Monofásico']);
            $table->decimal('transformer_power', 8, 2)->nullable();
            $table->decimal('energy_to_provide', 8, 2);
            $table->decimal('required_area', 8, 2);
            $table->decimal('panels_needed', 8, 2);
            $table->decimal('kilowatt_cost');
            $table->decimal('subtotal', 20, 2);
            $table->decimal('total', 20, 2);
            $table->enum('status', ['Generada', 'Ganada', 'Perdida', 'Expirada'])->default('Generada');
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
