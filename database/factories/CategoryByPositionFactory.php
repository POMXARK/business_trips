<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\CategoryByPosition;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<\App\Models\CategoryByPosition>
 */
final class CategoryByPositionFactory extends Factory
{
    /**
    * The name of the factory's corresponding model.
    *
    * @var string
    */
    protected $model = CategoryByPosition::class;

    /**
    * Define the model's default state.
    *
    * @return array
    */
    public function definition(): array
    {
        return [
            'staff_position_id' => \App\Models\StaffPosition::factory(),
            'vehicle_comfort_category_id' => \App\Models\VehicleComfortCategory::factory(),
            'deleted_at' => fake()->optional()->dateTime(),
        ];
    }
}
