<?php
namespace Database\Seeders\Models;

use App\Models\StaffPosition;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StaffPositionSeeder extends Seeder
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
        StaffPosition::factory()->count(5)->create();
    }
}
