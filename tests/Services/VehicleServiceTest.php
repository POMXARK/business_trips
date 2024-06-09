<?php

namespace Tests\Services;

use App\Models\CategoryByPosition;
use App\Models\Employee;
use App\Models\StaffPosition;
use App\Models\Stmt;
use App\Models\Trip;
use App\Models\User;
use App\Models\Vehicle;
use App\Models\VehicleComfortCategory;
use App\Notifications\StmtNotification;
use App\Services\StmtService;
use App\Services\VehicleService;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Laravel\Sanctum\Sanctum;
use PHPUnit\Framework\Attributes\Group;
use Tests\TestCase;

/**
 * Тесты сервиса автомобилей.
 *
 * @see StmtService
 */
#[Group('VehicleService')]
final class VehicleServiceTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * Успешная выборка автомобилей с фильтрацией.
     */
    public function testSearchFilterSuccess(): void
    {
        $vehicleService = app(VehicleService::class);
        $userId = rand(0, 99999);
        $employeeId = rand(0, 99999);
        $staffPositionId = rand(0, 99999);
        $vehicleComfortCategoryId = rand(0, 99999);
        $vehicleId = rand(0, 99999);
        $vehicleModel = 'model';
        $dateStart = '2024-25-06 09:47';
        $tripDate = '2024-25-06 09:50';
        Sanctum::actingAs(User::factory()->create(['id' => $userId]));
        $staffPosition = StaffPosition::factory()->create([
            'id' => $staffPositionId,
            'deleted_at' => null,
        ]);
        Employee::factory()->create([
            'id' => $employeeId,
            'user_id' => $userId,
            'staff_position_id' => $staffPosition->id,
            'deleted_at' => null,
        ]);
        $categoryByPosition = VehicleComfortCategory::factory()->create([
            'id' => $vehicleComfortCategoryId,
            'deleted_at' => null,
        ]);
        $vehicle = Vehicle::factory()->create([
            'id' => $vehicleId,
            'model' => $vehicleModel,
            'employee_id' => $employeeId,
            'vehicle_comfort_category_id' => $categoryByPosition->id,
            'user_id' => null,
            'deleted_at' => null,
        ]);
        Vehicle::factory()->create([
            'model' => $vehicleModel,
            'employee_id' => $employeeId,
            'vehicle_comfort_category_id' => $categoryByPosition->id,
            'user_id' => null,
            'deleted_at' => null,
        ]);
        CategoryByPosition::factory()->create([
            'staff_position_id' => $staffPositionId,
            'vehicle_comfort_category_id' => $categoryByPosition->id,
            'deleted_at' => null,
        ]);
        Trip::factory()->create([
            'date_start' => $dateStart,
            'vehicle_id' => $vehicle->id,
            'deleted_at' => null,
        ]);
        Trip::factory()->create([
            'date_start' => $tripDate,
            'vehicle_id' => $vehicle->id,
            'deleted_at' => null,
        ]);

        $params = [
            'date_start' => $dateStart,
            'category' => $categoryByPosition->vehicle_comfort_category_id,
            'model' => $vehicle->model,
        ];
        $models = $vehicleService->search($params['category'], $params['model'], $params['date_start'])['vehicles'];

        $this->assertNotEmpty($models);
        $this->assertCount(2, $models);
        foreach ($models as $model) {
            $this->assertSame(Vehicle::class, get_class($model));
        }
    }
}
