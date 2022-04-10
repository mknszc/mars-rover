<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PlateauController;
use App\Http\Controllers\RoverController;

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
Route::post('/createPlateau', [PlateauController::class, 'create']);
Route::post('/getPlateau', [PlateauController::class, 'get']);
Route::post('/crateRover', [RoverController::class, 'create']);
Route::post('/getRover', [RoverController::class, 'get']);
Route::post('/sendCommandRover', [RoverController::class, 'sendCommand']);
Route::post('/getRoverState', [RoverController::class, 'get']);