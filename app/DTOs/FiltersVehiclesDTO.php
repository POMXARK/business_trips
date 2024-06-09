<?php

namespace App\DTOs;

class FiltersVehiclesDTO
{
    public function __construct(
        public ?string $category,
        public ?string $model,
        public string  $inputDate,
    )
    {
    }
}
