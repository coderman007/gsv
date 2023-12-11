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
        Schema::create('job_positions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('category_id');
            $table->string('job_position_name');
            $table->decimal('daily_salary', 10, 2)->nullable(); // Calculado automáticamente
            $table->decimal('work_performance', 5, 2);
            $table->timestamps();

            $table->foreign('category_id')->references('id')->on('job_position_categories')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('job_positions');
    }
};
