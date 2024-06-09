<?php

namespace App\Http\Controllers\Api\V1;

use App\Actions\AvailableEmployeeVehiclesAction;
use App\DTOs\FiltersVehiclesDTO;
use App\Http\Controllers\Controller;
use App\Services\Business\VehicleService;
use Illuminate\Http\Request;

/**
 * Контроллер автомобилей.
 *
 * @see VehicleControllerTest
 */
class VehicleController extends Controller
{
    public function __construct(private readonly AvailableEmployeeVehiclesAction $availableEmployeeVehiclesAction)
    {
    }

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
        $dto = new FiltersVehiclesDTO(
            category: $request->input('category'),
            model: $request->input('model'),
            inputDate: $request->input('date_start'),
        );

        return response()->json(['data' => $this->availableEmployeeVehiclesAction->execute($dto)]);
    }
}
