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
        Schema::create('job_position_categories', function (Blueprint $table) {
            $table->id();
            $table->string('category_name');
            $table->text('category_description');
            $table->decimal('category_increment', 5, 2); // Porcentaje de incremento
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('job_position_categories');
    }
};
