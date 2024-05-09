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
        Schema::create('additional_cost_project', function (Blueprint $table) {
            $table->id();
            $table->foreignId('project_id')->constrained()->onDelete('cascade');
            $table->foreignId('additional_cost_id')->constrained()->onDelete('cascade');
            $table->bigInteger('quantity')->default(0)->nullable(false);
            $table->decimal('efficiency')->default(1.0)->nullable(false);
            $table->decimal('total_cost', 20)->default(0)->nullable(false);
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('additional_cost_project');
    }
};
