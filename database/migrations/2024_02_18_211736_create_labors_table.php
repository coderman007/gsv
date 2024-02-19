<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('labors', function (Blueprint $table) {
            $table->id();
            $table->string('position');
            $table->decimal('basic', 10, 2);
            $table->decimal('benefit_factor', 5, 2);
            $table->decimal('real_monthly_cost', 10, 2);
            $table->decimal('real_daily_cost', 10, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('labors');
    }
};
