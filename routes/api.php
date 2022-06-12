<?php

use App\Modules\Cars\Http\Controllers\CarController;
use App\Modules\Trips\Http\Controllers\TripController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::group(['middleware' => 'auth:sanctum'], function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    Route::apiResource('cars', CarController::class)->only(['index', 'store', 'show', 'destroy']);

    Route::apiResource('trips', TripController::class)->only(['index', 'store']);
});
