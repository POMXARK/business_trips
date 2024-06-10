<?php

namespace App\Http\Controllers\Api\V1\Showcase;

use App\Actions\AvailableEmployeeVehiclesAction;
use App\DTOs\FiltersVehiclesDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\AvailableVehicleRequest;
use OpenApi\Attributes as OAT;
use Symfony\Component\HttpFoundation\Response;

/**
 * Контроллер доступных автомобилей.
 *
 * @see VehicleControllerTest
 */
class AvailableVehicleController extends Controller
{
    public function __construct(private readonly AvailableEmployeeVehiclesAction $availableEmployeeVehiclesAction)
    {
    }

    #[OAT\Get(
        path: '/v1/showcase/available_vehicles/',
        description: 'Получение доступных автомобилей',
        summary: 'Получение доступных автомобилей',
        security: [
            ['bearerAuth' => []],
        ],
        tags: ['Автомобили'],
        parameters: [
            new OAT\Parameter(
                name: 'date_start',
                description: 'Планируемая дата начала аренды',
                in: 'query',
                required: true,
                schema: new OAT\Schema(
                    type: 'string',
                    example: '2022-04-03 09:47'
                )
            ),
            new OAT\Parameter(
                name: 'model',
                description: 'Модель автомобиля',
                in: 'query',
                required: false,
                schema: new OAT\Schema(
                    type: 'string',
                )
            ),
            new OAT\Parameter(
                name: 'category',
                description: 'Категория комфорта автомобиля',
                in: 'query',
                required: false,
                schema: new OAT\Schema(
                    type: 'int',
                ),
            ),
        ],
        responses: [
            new OAT\Response(
                response: Response::HTTP_OK,
                description: 'OK',
                content: new OAT\JsonContent(),
            ),
        ]
    )]
    public function index(AvailableVehicleRequest $request)
    {
        $dto = new FiltersVehiclesDTO(
            category: $request->input('category'),
            model: $request->input('model'),
            inputDate: $request->input('date_start'),
        );

        return response()->json(['data' => $this->availableEmployeeVehiclesAction->execute($dto)]);
    }
}
