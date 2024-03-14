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
        Schema::create('position_project', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('position_id');
            $table->unsignedBigInteger('project_id');
            $table->integer('quantity')->default(0)->nullable(false);
            $table->decimal('required_days', 5, 2)->default(0)->nullable(false);
            $table->decimal('total_cost', 10, 2)->default(0)->nullable(false);
            $table->timestamps();

            $table->foreign('position_id')->references('id')->on('positions')->cascadeOnDelete();
            $table->foreign('project_id')->references('id')->on('projects')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('position_project');
    }
};
