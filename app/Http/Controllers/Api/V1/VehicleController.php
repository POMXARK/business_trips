<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use App\Models\Trip;
use App\Models\Vehicle;
use DateTime;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Http\Request;

class VehicleController extends Controller
{
    /**
     * @OA\Get(
     *     path="/v1/showcase/available_vehicles/",
     *     summary="Получение доступных автомобилей",
     *     tags={"Автомобили"},
     *          @OA\Parameter(
     *          name="date_start",
     *          in="query",
     *          description="Планируемая дата начала аренды",
     *          required=false,
     *          @OA\Schema(
     *              type="date",
     *              format="date",
     *              example="2022-04-03 09:47"
     *          )
     *      ),
     *      @OA\Parameter(
     *           name="model",
     *           in="query",
     *           description="Модель автомобиля",
     *           required=false,
     *           @OA\Schema(
     *               type="string",
     *               example=""
     *           )
     *       ),
     *      @OA\Parameter(
     *            name="category",
     *            in="query",
     *            description="Категория комфорта автомобиля",
     *            required=false,
     *            @OA\Schema(
     *                type="int",
     *                example=""
     *            )
     *        ),
     *     @OA\Response(
     *          response=200,
     *          description="Успешная операция",
     *          @OA\JsonContent()
     *     ),
     *     security={
     *           {"bearerAuth": {}, {}}
     *      }
     * )
     */
    public function index(Request $request)
    {
        $data = Employee::query()
            ->where('user_id', auth()->id())
            ->with('categoriesByPosition')
            ->get();

        $categoriesByPosition = $data->flatMap(fn(Employee $employee) => $employee->categoriesByPosition);

        $availableCategoriesVehicle = $categoriesByPosition->pluck('vehicle_comfort_category_id');

        $query = Vehicle::query();

        if ($category = $request->input('category')) {
            $query = $query->where('vehicle_comfort_category_id', $category);
        }

        if ($model = $request->input('model')) {
            $query = $query->where('model', $model);
        }

        $inputDate = $request->input('date_start');
        $dateStart = DateTime::createFromFormat('Y-m-d H:i', $inputDate);

        $out = $query
            ->whereIn('vehicle_comfort_category_id', $availableCategoriesVehicle)
            ->where('user_id', null)
            ->with('trips', fn(HasMany $query) => $query
                ->whereDate('date_start', '>=', $dateStart))
            ->get();

        $availableVehicles = [];

        $out->each(function (Vehicle $item) use ($inputDate, &$availableVehicles) {
            $item->trips->each(function (Trip $trip) use ($inputDate, $item, &$availableVehicles) {
                $date = date('Y-m-d H:i', strtotime($trip->date_start));
                if ($date !== $inputDate) {
                    $availableVehicles[] = $item;
                }
            });

            if (count($item->trips) == 0) {
                $availableVehicles[] = $item;
            }
        });

        return response()->json(['data' => ['vehicles' => $availableVehicles]]);
    }
}
