<?php
namespace Database\Seeders\Models;

use App\Models\Trip;
use App\Models\Vehicle;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TripSeeder extends Seeder
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
        Trip::factory()
            ->sequence(fn() => [
                'vehicle_id' => Vehicle::all()->random(),
            ])
            ->count(200)->create();
    }
}
