<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\StaffPosition;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<\App\Models\StaffPosition>
 */
final class StaffPositionFactory extends Factory
{
    /**
    * The name of the factory's corresponding model.
    *
    * @var string
    */
    protected $model = StaffPosition::class;

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
