<?php

namespace App\Services;

use App\Models\Trip;
use App\Models\Vehicle;
use App\Repositories\VehicleRepositoryInterface;

/**
 * Сервис автомобилей.
 *
 * @see VehicleServiceTest
 */
readonly class VehicleService
{
    public function __construct(private VehicleRepositoryInterface $vehicleRepository)
    {
    }

    /**
     * Все доступные автомобили с фильтрацией по статусу и дате.
     */
    public function search(?string $category, ?string $model, string $dateStart): array
    {
        $inputDate = $dateStart;
        $out = $this->vehicleRepository->search($category, $model, $dateStart);
        $availableVehicles = [];

        $out->each(function (Vehicle $item) use ($inputDate, &$availableVehicles) {
            $item->trips->each(function (Trip $trip) use ($inputDate, $item, &$availableVehicles) {
                $date = date('Y-m-d H:i', strtotime($trip->date_start));
                if ($date !== $inputDate) {
                    $availableVehicles[] = $item;
                }
            });

            if (count($item->trips) == 0) {
                $availableVehicles[] = $item;
            }
        });

        return ['vehicles' => $availableVehicles];
    }
}
