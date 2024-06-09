<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Collection;

/**
 * Интерфейс репозитория автомобилей.
 */
interface VehicleRepositoryInterface
{
    /**
     * Поиск моделей.
     */
    public function search(?string $category, ?string $model, string $dateStart): Collection;
}
