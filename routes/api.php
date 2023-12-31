<?php

use App\Http\Controllers\Api\ApartmentController;
use App\Http\Controllers\Api\MessaggeController;
use App\Http\Controllers\Api\ServiceController;
use App\Http\Controllers\Api\VisitController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::apiResource('/apartments/visit', VisitController::class);
Route::apiResource('/apartments/messagge', MessaggeController::class);
Route::get('apartments/services', [ServiceController::class, 'index']);
Route::apiResource('/apartments', ApartmentController::class);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
