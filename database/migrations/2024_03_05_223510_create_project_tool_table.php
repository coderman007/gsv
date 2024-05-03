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
        Schema::create('project_tool', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('project_id');
            $table->unsignedBigInteger('tool_id');
            $table->integer('quantity')->default(0)->nullable(false);
            $table->integer('required_days')->default(0)->nullable(false);
            $table->decimal('efficiency')->default(1.0)->nullable(false);
            $table->decimal('total_cost', 20)->default(0)->nullable(false);
            $table->timestamps();

            $table->foreign('project_id')->references('id')->on('projects')->cascadeOnDelete();
            $table->foreign('tool_id')->references('id')->on('tools')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('project_tool');
    }
};
