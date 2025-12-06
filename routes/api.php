<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ServiceController;
use App\Http\Controllers\Api\BookingAvailabilityController;
use App\Http\Controllers\Api\BookingController;
use App\Http\Controllers\Api\WorkingTimeController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/services', [ServiceController::class, 'index']);
Route::get('/availability', [BookingAvailabilityController::class, 'index']);
Route::post('/bookings', [BookingController::class, 'store']);

Route::get('/working-times', [WorkingTimeController::class, 'index']);
Route::post('/working-times', [WorkingTimeController::class, 'store']);
Route::delete('/working-times/{id}', [WorkingTimeController::class, 'destroy']);

Route::get('/admin/bookings', [BookingController::class, 'index']);

