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
        Schema::create('project_transport', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('project_id');
            $table->unsignedBigInteger('transport_id');
            $table->bigInteger('quantity')->default(0)->nullable(false);
            $table->bigInteger('required_days')->default(0)->nullable(false);
            $table->decimal('efficiency')->default(1.0)->nullable(false);
            $table->decimal('total_cost', 20)->default(0)->nullable(false);
            $table->timestamps();

            $table->foreign('project_id')->references('id')->on('projects')->cascadeOnDelete();
            $table->foreign('transport_id')->references('id')->on('transports')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('project_transport');
    }
};
