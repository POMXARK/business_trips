<?php

namespace App\Actions;

use App\Builders\AvailableEmployeeVehiclesBuilder;
use App\DTOs\FiltersVehiclesDTO;

/**
 *  Действие для получения списка доступных автомобилей.
 *
 * @see AvailableEmployeeVehiclesActionTest
 */
readonly class AvailableEmployeeVehiclesAction
{
    /**
     * Запуск действия.
     */
    public function execute(FiltersVehiclesDTO $dto): array
    {
        $builder = new AvailableEmployeeVehiclesBuilder(dto: $dto, userId: auth()->id());

        return $builder->execute();
    }
}
