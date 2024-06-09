<?php

namespace App\Actions;

use App\DTOs\FiltersVehiclesDTO;
use App\Models\Employee;
use App\Models\Trip;
use App\Models\Vehicle;
use DateTime;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Builder;

/**
 * @see AvailableEmployeeVehiclesActionTest
 */
readonly class AvailableEmployeeVehiclesAction
{
    public function execute(FiltersVehiclesDTO $dto): array
    {
        $categoriesByPosition = $this->getCategoriesByPosition(userId: auth()->id());
        $availableCategoriesVehicle = $categoriesByPosition->flatten()->pluck('vehicle_comfort_category_id');
        $query = $this->filters($dto);
        $out = $this->getNowFreeVehiclesByPosition($query, $dto, $availableCategoriesVehicle);

        return ['vehicles' => $this->getAvailableVehicles($out, $dto)];
    }

    /**
     * Получить доступные для пользователя категории комфорта автомобиля.
     */
    private function getCategoriesByPosition(int $userId): \Illuminate\Support\Collection
    {
        $data = Employee::query()
            ->where('user_id', $userId)
            ->with('categoriesByPosition')
            ->get();

        $categoriesByPosition = collect();
        $data->each(function (Employee $employee) use ($categoriesByPosition) {
            $categoriesByPosition->push($employee->categoriesByPosition);
        });

        return $categoriesByPosition;
    }

    /**
     * Фильтровать автомобили.
     */
    private function filters(FiltersVehiclesDTO $dto): Builder
    {
        $query = Vehicle::query();
        $this->filterCategory($query, $dto);
        $this->filterModel($query, $dto);

        return $query;
    }

    /**
     * Фильтровать по категории комфорта.
     */
    private function filterCategory(Builder &$query, FiltersVehiclesDTO $dto): void
    {
        if ($dto->category) {
            $query = $query->where('vehicle_comfort_category_id', $dto->category);
        }
    }

    /**
     * Фильтровать по модели автомобиля.
     */
    private function filterModel(Builder &$query, FiltersVehiclesDTO $dto): void
    {
        if ($dto->model) {
            $query = $query->where('model', $dto->model);
        }
    }

    /**
     * Получить доступные по должности в данный момент на указанную дату автомобили.
     */
    public function getNowFreeVehiclesByPosition(Builder &$query,
                                    FiltersVehiclesDTO $dto,
                                    \Illuminate\Support\Collection $availableCategoriesVehicle): Collection|array
    {
        $dateStart = DateTime::createFromFormat('Y-m-d H:i', $dto->inputDate);

        return $query
            ->whereIn('vehicle_comfort_category_id', $availableCategoriesVehicle)
            ->where('user_id', null)
            ->with('trips', fn(HasMany $query) => $query
                ->whereDate('date_start', '>=', $dateStart))
            ->get();
    }

    /**
     * Получить доступные автомобили.
     */
    public function getAvailableVehicles(Collection|array $out, FiltersVehiclesDTO $dto): array
    {
        $availableVehicles = [];
        $out->each(function (Vehicle $item) use ($dto, &$availableVehicles) {
            $item->trips->each(function (Trip $trip) use (&$dto, $item, &$availableVehicles) {
                $date = date('Y-m-d H:i', strtotime($trip->date_start));
                if ($date !== $dto->inputDate) {
                    $availableVehicles[] = $item;
                }
            });
            if (count($item->trips) == 0) {
                $availableVehicles[] = $item;
            }
        });

        return $availableVehicles;
    }
}
