<?php

namespace App\Repositories;

use App\Models\Employee;
use App\Models\Vehicle;
use DateTime;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Репозиторий автомобилей.
 */
class VehicleRepository implements VehicleRepositoryInterface
{
    /**
     * Поиск моделей.
     */
    public function search(?string $category, ?string $model, string $dateStart): Collection
    {
        $data = Employee::query()
            ->where('user_id', auth()->id())
            ->with('categoriesByPosition')
            ->get();

        $categoriesByPosition = collect();
        $data->each(function (Employee $employee) use ($categoriesByPosition) {
            $categoriesByPosition->push($employee->categoriesByPosition);
        });

        $availableCategoriesVehicle = $categoriesByPosition->flatten()->pluck('vehicle_comfort_category_id');

        $query = Vehicle::query();

        if ($category) {
            $query = $query->where('vehicle_comfort_category_id', $category);
        }

        if ($model) {
            $query = $query->where('model', $model);
        }

        $inputDate = $dateStart;
        $dateStart = DateTime::createFromFormat('Y-m-d H:i', $inputDate);

        $out = $query
            ->whereIn('vehicle_comfort_category_id', $availableCategoriesVehicle)
            ->where('user_id', null)
            ->with('trips', fn(HasMany $query) => $query
                ->whereDate('date_start', '>=', $dateStart))
            ->get();

        return $out;
    }
}
