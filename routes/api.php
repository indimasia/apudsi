<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\SosController;
use App\Http\Controllers\API\ChatController;
use App\Http\Controllers\API\ShopController;
use App\Http\Controllers\API\AgentController;
use App\Http\Controllers\API\GroupController;
use App\Http\Controllers\API\ArticleController;
use App\Http\Controllers\API\ProfileController;
use App\Http\Controllers\API\VersionController;
use App\Http\Controllers\API\Auth\LoginController;
use App\Http\Controllers\API\AgentReportController;
use App\Http\Controllers\API\Auth\LogoutController;
use App\Http\Controllers\API\Master\CityController;
use App\Http\Controllers\API\Auth\RegisterController;
use App\Http\Controllers\API\Master\VillageController;
use App\Http\Controllers\API\UpdateLocationController;
use App\Http\Controllers\API\AccountDeletionController;
use App\Http\Controllers\API\Master\DistrictController;
use App\Http\Controllers\API\Master\ProvinceController;
use App\Http\Controllers\API\Auth\ForgotPasswordController;
use App\Http\Controllers\API\DashboardController;
use App\Http\Controllers\API\ProductController;

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
    Route::post('/forgot-password', ForgotPasswordController::class);
});

Route::group(['prefix' => 'masters'], function () { 
    Route::get('/provinces', ProvinceController::class);
    Route::get('/cities', CityController::class);
    Route::get('/districts', DistrictController::class);
    Route::get('/villages', VillageController::class);
});

Route::middleware('auth:sanctum')->group(function () {
    Route::resource('shops', ShopController::class)->except(['edit']);

    // Update Location
    Route::post('/update-location', UpdateLocationController::class);

    // Profile
    Route::get('/profile', [ProfileController::class, 'show']);
    Route::post('/profile', [ProfileController::class, 'update']);

    // Article
    Route::get('/articles/{id}', [ArticleController::class, 'show']);
    Route::resource('articles', ArticleController::class)->except(['show']);
    
    Route::get('/home', [DashboardController::class, 'show']);
    // Sos
    Route::resource('sos', SosController::class);
    Route::resource('product', ProductController::class);

    // Group
    Route::get('/groups/{groupId}/members', [GroupController::class, 'members']);
    Route::post('/groups/{groupId}/join', [GroupController::class, 'join']);
    Route::post('/groups/{groupId}/leave', [GroupController::class, 'leave']);
    Route::post('/groups/{groupId}/remove-user/{userId}', [GroupController::class, 'removeUser']);
    Route::resource('groups', GroupController::class);

    // Chat
    Route::resource('groups/{groupId}/chats', ChatController::class);

    // Account Deletion
    Route::post('/account-deletion', AccountDeletionController::class);

    // Agent
    Route::resource('agents', AgentController::class)->only(['index', 'show']);
    Route::resource('agents/{agentId}/reports', AgentReportController::class);
});
    