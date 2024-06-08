<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Trip;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<\App\Models\Trip>
 */
final class TripFactory extends Factory
{
    /**
    * The name of the factory's corresponding model.
    *
    * @var string
    */
    protected $model = Trip::class;

    /**
    * Define the model's default state.
    *
    * @return array
    */
    public function definition(): array
    {
        return [
            'vehicle_id' => \App\Models\Vehicle::factory(),
            'date_start' => fake()->dateTime(),
            'date_end' => fake()->optional()->dateTime(),
            'deleted_at' => fake()->optional()->dateTime(),
        ];
    }
}
