<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\ShopController;
use App\Http\Controllers\API\ProfileController;
use App\Http\Controllers\API\VersionController;
use App\Http\Controllers\API\Auth\LoginController;
use App\Http\Controllers\API\Auth\LogoutController;
use App\Http\Controllers\API\Master\CityController;
use App\Http\Controllers\API\Auth\RegisterController;
use App\Http\Controllers\API\Master\VillageController;
use App\Http\Controllers\API\Master\DistrictController;
use App\Http\Controllers\API\Master\ProvinceController;
use App\Http\Controllers\API\Auth\ForgotPasswordController;

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

Route::get('/version', VersionController::class);

Route::group(['prefix' => 'auth'], function () {
    Route::post('/register', RegisterController::class);
    Route::post('/login', LoginController::class);
    Route::post('/logout', LogoutController::class)->middleware('auth:sanctum');
    // Route::post('/forgot-password', ForgotPasswordController::class);
});

Route::group(['prefix' => 'masters'], function () { 
    Route::get('/provinces', ProvinceController::class);
    Route::get('/cities', CityController::class);
    Route::get('/districts', DistrictController::class);
    Route::get('/villages', VillageController::class);
});

Route::middleware('auth:sanctum')->group(function () {
    Route::resource('shops', ShopController::class)->except(['edit']);

    Route::get('/profile', [ProfileController::class, 'getProfile']);
});
    