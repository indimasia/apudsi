<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\Master\CityController;
use App\Http\Controllers\API\Master\DistrictController;
use App\Http\Controllers\API\Master\VillageController;
use App\Http\Controllers\API\Auth\RegisterController;
use App\Http\Controllers\API\Master\ProvinceController;

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

Route::group(['prefix' => 'auth'], function () {
    Route::post('/register', RegisterController::class);
});

Route::group(['prefix' => 'masters'], function () { 
    Route::get('/provinces', ProvinceController::class);
    Route::get('/cities', CityController::class);
    Route::get('/districts', DistrictController::class);
    Route::get('/villages', VillageController::class);
});
    
