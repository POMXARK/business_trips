<?php
namespace Database\Seeders\Models;

use App\Models\CategoryByPosition;
use App\Models\StaffPosition;
use App\Models\VehicleComfortCategory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategoryByPositionSeeder extends Seeder
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
        CategoryByPosition::factory()
            ->sequence(fn() => [
                'staff_position_id' => StaffPosition::all()->random(),
                'vehicle_comfort_category_id' => VehicleComfortCategory::all()->random(),
            ])
            ->count(20)->create();
    }
}
