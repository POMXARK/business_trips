<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property int $id
 * @property string $number Регистрационный номер.
 * @property string $model Модель.
 * @property int|null $employee_id Водитель.
 * @property int|null $vehicle_comfort_category_id Категория комфорта автомобиля.
 * @property int|null $user_id Забронировано за сотрудником.
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\CategoryByPosition> $categoryByPositions
 */
class Vehicle extends Model
{
    use HasFactory, SoftDeletes;

    public function categoryByPositions(): HasMany
    {
        return $this->hasMany(CategoryByPosition::class);
    }

    public function trips(): HasMany
    {
        return $this->hasMany(Trip::class);
    }

    public function vehicleComfortCategory(): BelongsTo
    {
        return $this->belongsTo(VehicleComfortCategory::class);
    }

    public function employee(): BelongsTo
    {
        return $this->belongsTo(Employee::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
