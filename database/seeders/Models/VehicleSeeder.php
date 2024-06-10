<?php
namespace Database\Seeders\Models;

use App\Models\Employee;
use App\Models\User;
use App\Models\Vehicle;
use App\Models\VehicleComfortCategory;
use Illuminate\Database\Seeder;

class VehicleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /**
         * Command :
         * artisan seed:generate --mode=model --models=User,Vehicle,StaffPosition,Employee,VehicleComfortCategory,Trip,CategoryByPosition
         *
         */
        Vehicle::factory()
            ->sequence(fn() => [
                'employee_id' => Employee::all()->random(),
                'vehicle_comfort_category_id' => VehicleComfortCategory::all()->random(),
                'user_id' => fake()->randomElement([User::all()->random(), null]),
            ])
            ->count(20)->create();
    }
}
