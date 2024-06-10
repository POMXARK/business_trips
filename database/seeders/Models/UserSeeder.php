<?php
namespace Database\Seeders\Models;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Throwable;

class UserSeeder extends Seeder
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
        User::factory()->count(19)->create();

        try {
            User::factory()->create([
                'name' => 'admin',
                'password' => Hash::make('123456789'),
                'email' => 'test@example.com',
            ]);
        } catch (Throwable $th) {}
    }
}
