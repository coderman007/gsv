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
        Schema::create('positions', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->decimal('basic', 20);
            $table->unsignedSmallInteger('monthly_work_hours')->default(173);
            $table->unsignedSmallInteger('working_hours')->default(8);
            $table->decimal('benefit_factor', 5);
            $table->decimal('real_monthly_cost', 20);
            $table->decimal('real_daily_cost', 20);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('positions');
    }
};


