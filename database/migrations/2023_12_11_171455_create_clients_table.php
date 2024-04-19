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
            $table->unsignedBigInteger('city_id');

            $table->enum('type', ['Persona', 'Empresa']);
            $table->string('name');
            $table->string('representative')->nullable();
            $table->string('email')->nullable()->unique();
            $table->string('address')->nullable();
            $table->string('document')->nullable()->unique();
            $table->string('phone')->nullable();
            $table->string('image')->nullable();
            $table->enum('status', ['Activo', 'Inactivo'])->default('Activo');

            $table->foreign('city_id')->references('id')->on('cities')->cascadeOnDelete();
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
