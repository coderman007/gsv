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

            $table->string('name');
            $table->string('zone');
            $table->double('kilowatts_to_provide', 5, 2);
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
