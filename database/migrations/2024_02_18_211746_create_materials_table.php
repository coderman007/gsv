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
        Schema::create('materials', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('material_category_id');
            $table->string('reference');
            $table->string('description');
            $table->double('unit_price');
            $table->string('image')->nullable();
            $table->timestamps();

            $table->foreign('material_category_id')->references('id')->on('material_categories')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('materials');
    }
};
