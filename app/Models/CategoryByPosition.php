<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property int $id
 * @property int $staff_position_id Должность.
 * @property int $vehicle_comfort_category_id Категория комфорта автомобиля.
 */
class CategoryByPosition extends Model
{
    use HasFactory, SoftDeletes;
}
