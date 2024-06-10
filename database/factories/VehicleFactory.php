<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Vehicle;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<\App\Models\Vehicle>
 */
final class VehicleFactory extends Factory
{
    /**
    * The name of the factory's corresponding model.
    *
    * @var string
    */
    protected $model = Vehicle::class;

    /**
    * Define the model's default state.
    *
    * @return array
    */
    public function definition(): array
    {
        return [
            'number' => fake()->word,
            'model' => fake()->word,
            'employee_id' => \App\Models\Employee::factory(),
            'vehicle_comfort_category_id' => \App\Models\VehicleComfortCategory::factory(),
            'user_id' => \App\Models\User::factory(),
            'deleted_at' => fake()->optional()->dateTime(),
        ];
    }
}
