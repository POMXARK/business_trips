<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\VehicleComfortCategory;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<\App\Models\VehicleComfortCategory>
 */
final class VehicleComfortCategoryFactory extends Factory
{
    /**
    * The name of the factory's corresponding model.
    *
    * @var string
    */
    protected $model = VehicleComfortCategory::class;

    /**
    * Define the model's default state.
    *
    * @return array
    */
    public function definition(): array
    {
        return [
            'name' => fake()->name,
            'deleted_at' => fake()->optional()->dateTime(),
        ];
    }
}
