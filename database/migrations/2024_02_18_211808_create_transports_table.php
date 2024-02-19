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
        Schema::create('transports', function (Blueprint $table) {
            $table->id();
            $table->string('vehicle_type');
            $table->integer('annual_mileage');
            $table->decimal('average_speed', 5, 2);
            $table->decimal('commercial_value', 15, 2);
            $table->decimal('depreciation_rate', 5, 2);
            $table->decimal('annual_maintenance_cost', 15, 2);
            $table->decimal('cost_per_km_conventional', 10, 2);
            $table->decimal('cost_per_km_fuel', 10, 2);
            $table->decimal('salary_per_month', 15, 2);
            $table->decimal('salary_per_hour', 10, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transports');
    }
};
