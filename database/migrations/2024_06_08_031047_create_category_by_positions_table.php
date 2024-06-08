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
        Schema::create('category_by_positions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('staff_position_id')->comment('Должность')->constrained();
            $table->foreignId('vehicle_comfort_category_id')->comment('Категория комфорта')->constrained();
            $table->timestamps();

            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('category_by_positions');
    }
};
