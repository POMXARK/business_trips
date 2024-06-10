<?php

use App\Http\Controllers\Api\V1\Auth\AuthController;
use App\Http\Controllers\Api\V1\Showcase\AvailableVehicleController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::prefix('v1')->group(function () {
    Route::post('/tokens/create', [AuthController::class, 'token'])->name('login');
    Route::middleware('auth:sanctum')->group(function () {
        Route::get('/showcase/available_vehicles/', [AvailableVehicleController::class, 'index'])
            ->name('available_vehicles');
    });
});
