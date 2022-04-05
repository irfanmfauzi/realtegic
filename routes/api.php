<?php

use App\Http\Controllers\ReportController;
use App\Http\Controllers\SurvivorController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::post('survivor/trade', [SurvivorController::class, 'trade']);
Route::put('survivor/{id}/location', [SurvivorController::class, 'update_location']);
Route::put('survivor/{id}/infected', [SurvivorController::class, 'update_infected']);
Route::apiResource('survivor', SurvivorController::class);

Route::prefix('report')->group(function () {
    Route::get('infected', [ReportController::class, 'infected']);
    Route::get('non-infected', [ReportController::class, 'non_infected']);
    Route::get('average-resource', [ReportController::class, 'avg_resource']);
});
