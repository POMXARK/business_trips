<?php

use App\Http\Controllers\Api\V1\AuthController;
use App\Http\Controllers\Api\V1\VehicleController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::prefix('v1')->group(function () {
    Route::post('/tokens/create', [AuthController::class, 'token']);
    Route::middleware('auth:sanctum')->group(function () {
        Route::get('/showcase/available_vehicles/', [VehicleController::class, 'index']);
    });
});
