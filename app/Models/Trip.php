<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property int $id
 * @property int $vehicle_id Автомобиль.
 * @property mixed $date_start Начало бронирования автомобиля.
 * @property string|null $date_end Окончание бронирования автомобиля.
 */
class Trip extends Model
{
    use HasFactory, SoftDeletes;
}
