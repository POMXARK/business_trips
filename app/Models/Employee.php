<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property mixed $categoriesByPosition Категории комфорта автомобиля доступные сотрудникам с определенной должностью
 */
class Employee extends Model
{
    use HasFactory, SoftDeletes;

    public function staffPosition(): BelongsTo
    {
        return $this->belongsTo(StaffPosition::class);
    }

    public function categoriesByPosition(): HasMany
    {
        return $this->hasMany(CategoryByPosition::class,
            'staff_position_id', 'staff_position_id');
    }
}
