<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;

class VehicleController extends Controller
{
    /**
     * @OA\Get(
     *     path="/v1/showcase/vehicles/",
     *     summary="Получение доступных автомобилей",
     *     tags={"Автомобили"},
     *          @OA\Parameter(
     *          name="date_start",
     *          in="query",
     *          description="Дата начала аренды",
     *          required=true,
     *          @OA\Schema(
     *              type="date",
     *              format="date",
     *              example=""
     *          )
     *      ),
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
    public function index()
    {
        //
    }
}
