<?php

namespace App\DTOs;

class FiltersVehiclesDTO
{
    /**
     * @param string|null $category Категория комфорта.
     * @param string|null $model Модель.
     * @param string $inputDate Планируемая дата бронирования.
     */
    public function __construct(
        public ?string $category,
        public ?string $model,
        public string  $inputDate,
    )
    {
    }
}
