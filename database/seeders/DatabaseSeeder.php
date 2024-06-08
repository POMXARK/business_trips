<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(\Database\Seeders\Models\UserSeeder::class);
        $this->call(\Database\Seeders\Models\StaffPositionSeeder::class);
        $this->call(\Database\Seeders\Models\EmployeeSeeder::class);
        $this->call(\Database\Seeders\Models\VehicleComfortCategorySeeder::class);
        $this->call(\Database\Seeders\Models\VehicleSeeder::class);
        $this->call(\Database\Seeders\Models\TripSeeder::class);
        $this->call(\Database\Seeders\Models\CategoryByPositionSeeder::class);
    }
}
