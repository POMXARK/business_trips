<?php

namespace App\Builders;

use App\DTOs\FiltersVehiclesDTO;
use App\Models\Employee;
use App\Models\Trip;
use App\Models\Vehicle;
use DateTime;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Collection;

class AvailableEmployeeVehiclesBuilder
{
    public function __construct(
        public FiltersVehiclesDTO $dto,
        public int                $userId,
        public ?Collection        $categoriesByPosition = new Collection(),
        public ?Builder           $employeeBuilder = null,
        public ?Builder           $vehicleBuilder = null,
        public ?Collection        $vehicles = new Collection(),
        public ?Collection        $availableCategoriesVehicle = new Collection(),
        public ?Collection        $availableVehicles = new Collection(),

    )
    {
        $this->employeeBuilder ??= Employee::query();
        $this->vehicleBuilder ??= Vehicle::query();
    }

    public function execute()//: array
    {
        return $this->categoriesByPosition()
            ->filters()
            ->nowFreeVehiclesByPosition()
            ->availableVehicles()
            ->getAvailableVehicles();
    }

    /**
     * Получить доступные автомобили.
     */
    public function getAvailableVehicles()//: array
    {
        return ['vehicles' => $this->availableVehicles->unique()];
    }

    /**
     * Доступные для пользователя категории комфорта автомобиля.
     */
    public function categoriesByPosition(): static
    {
        $data = Employee::query()
            ->where('user_id', $this->userId)
            ->with('categoriesByPosition')
            ->get();

        $categoriesByPosition = collect();
        $data->each(function (Employee $employee) use ($categoriesByPosition) {
            $categoriesByPosition->push($employee->categoriesByPosition);
        });

        $this->categoriesByPosition = $categoriesByPosition;

        return $this;
    }

    /**
     * Фильтровать автомобили.
     */
    private function filters(): static
    {
        $this->filterCategory();
        $this->filterModel();

        return $this;
    }

    /**
     * Фильтровать по категории комфорта.
     */
    private function filterCategory(): void
    {
        if ($this->dto->category) {
            $this->vehicleBuilder = $this->vehicleBuilder
                ->where('vehicle_comfort_category_id', $this->dto->category);
        }
    }

    /**
     * Фильтровать по модели автомобиля.
     */
    private function filterModel(): void
    {
        if ($this->dto->model) {
            $this->vehicleBuilder = $this->vehicleBuilder->where('model', $this->dto->model);
        }
    }

    /**
     *  Доступные по должности в данный момент на указанную дату автомобили.
     */
    public function nowFreeVehiclesByPosition(): static
    {
        $this->formatCategoriesByPosition();

        $dateStart = DateTime::createFromFormat('Y-m-d H:i', $this->dto->inputDate);
        $this->vehicles = $this->vehicleBuilder
            ->whereIn('vehicle_comfort_category_id', $this->availableCategoriesVehicle)
            ->where('user_id', null)
            ->with('trips', fn(HasMany $query) => $query
                ->whereDate('date_start', '>=', $dateStart))
            ->get();

        return $this;
    }

    /**
     * Форматировать структуру.
     */
    private function formatCategoriesByPosition(): void
    {
        $this->availableCategoriesVehicle = $this->categoriesByPosition->flatten()
            ->pluck('vehicle_comfort_category_id');
    }

    /**
     * Доступные автомобили.
     */
    public function availableVehicles(): static
    {
        $this->availableVehicles = collect();
        $this->vehicles->each(function (Vehicle $item) {
            $item->trips->each(function (Trip $trip) use ($item) {
                $date = date('Y-m-d H:i', strtotime($trip->date_start));
                if ($date !== $this->dto->inputDate) {
                    $this->availableVehicles->push($item);
                }
            });
            if (count($item->trips) == 0) {
                $this->availableVehicles->push($item);
            }
        });

        return $this;
    }
}
