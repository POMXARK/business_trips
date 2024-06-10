<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Автомобили
 */
return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('vehicles', function (Blueprint $table) {
            $table->id();
            $table->string('number')->comment('Регистрационный номер');
            $table->string('model')->comment('Модель');
            $table->foreignId('employee_id')->nullable()->comment('Водитель')->constrained()->nullOnDelete();
            $table->foreignId('vehicle_comfort_category_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('user_id')->nullable()->comment('Забронировано за сотрудником')->constrained()->nullOnDelete();
            $table->timestamps();

            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vehicles');
    }
};
