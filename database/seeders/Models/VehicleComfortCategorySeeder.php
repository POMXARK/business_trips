<?php
namespace Database\Seeders\Models;

use App\Models\VehicleComfortCategory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class VehicleComfortCategorySeeder extends Seeder
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
        VehicleComfortCategory::factory()->count(20)->create();
    }
}
