<?php

namespace App\Actions;

use App\Builders\AvailableEmployeeVehiclesBuilder;
use App\DTOs\FiltersVehiclesDTO;

/**
 * @see AvailableEmployeeVehiclesActionTest
 */
readonly class AvailableEmployeeVehiclesAction
{
    public function execute(FiltersVehiclesDTO $dto): array
    {
        $builder = new AvailableEmployeeVehiclesBuilder(dto: $dto, userId: auth()->id());

        return $builder->execute();
    }
}
