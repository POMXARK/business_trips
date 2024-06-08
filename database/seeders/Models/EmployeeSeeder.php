<?php
namespace Database\Seeders\Models;

use App\Models\Employee;
use App\Models\StaffPosition;
use App\Models\User;
use Illuminate\Database\Seeder;

class EmployeeSeeder extends Seeder
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
        Employee::factory()
            ->sequence(fn() => [
                'user_id' => User::all()->random(),
                'staff_position_id' => StaffPosition::all()->random(),
            ])
            ->count(20)->create();
    }
}
