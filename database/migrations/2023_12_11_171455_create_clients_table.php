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
            $table->unsignedBigInteger('location_id');

            $table->string('name');
            $table->string('email')->unique();
            $table->string('phone');
            $table->string('transformer');
            $table->decimal('average_energy_consumption', 10, 2);
            $table->decimal('roof_dimension', 8, 2);
            $table->enum('status', ['Activo', 'Inactivo'])->default('Activo');
            $table->string('image')->nullable();

            $table->foreign('location_id')->references('id')->on('locations')->cascadeOnDelete();
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
