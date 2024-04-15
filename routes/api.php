<?php

use App\Http\Controllers\API\VersionController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
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

Route::get('/version', VersionController::class);
Route::group(['prefix' => 'auth'], function () {
    Route::group(['prefix' => 'v2'], function() {
        Route::post('/register', 'App\Http\Controllers\API\Auth\V2\RegisterController');
        Route::post('/login', 'App\Http\Controllers\API\Auth\V2\LoginController');
    });
    Route::post('/register', 'App\Http\Controllers\API\Auth\RegisterController');
    Route::post('/login', 'App\Http\Controllers\API\Auth\LoginController');
    Route::post('/logout', 'App\Http\Controllers\API\Auth\LogoutController')->middleware('auth:sanctum');
    Route::post("/forgot-password", "App\Http\Controllers\API\Auth\ForgotPasswordController");
});

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/profile', 'App\Http\Controllers\API\ProfileController@getProfile');
    Route::post('/profile', 'App\Http\Controllers\API\ProfileController@postProfile');

    Route::resource('/biro-articles', 'App\Http\Controllers\API\BiroArticleController');
    Route::resource('/visit-saudi-articles', 'App\Http\Controllers\API\VisitSaudiArticleController');
    Route::resource('/culinary-articles', 'App\Http\Controllers\API\CulinaryArticleController');
    Route::resource('/tips-articles', 'App\Http\Controllers\API\TipsArticleController');
    Route::resource('/hidden-gem-articles', 'App\Http\Controllers\API\HiddenGemArticleController');
    Route::resource('/health-articles', 'App\Http\Controllers\API\HealthArticleController');
    Route::resource('/banners', 'App\Http\Controllers\API\BannerController');
    Route::resource('/pray-articles', 'App\Http\Controllers\API\PrayArticleController');
    Route::resource('/packages', 'App\Http\Controllers\API\PackageController');
    Route::get('/biro-users/download', 'App\Http\Controllers\API\BiroUserController@download');
    Route::resource('/biro-users', 'App\Http\Controllers\API\BiroUserController');
    Route::resource('/emergencies', 'App\Http\Controllers\API\EmergencyController');
    Route::resource('/groups', 'App\Http\Controllers\API\GroupController');
    Route::resource('/testimonies', 'App\Http\Controllers\API\TestimonyController');
    
    Route::get('/groups/{groupId}/members', 'App\Http\Controllers\API\GroupController@members');
    Route::post('/groups/{groupId}/join', 'App\Http\Controllers\API\GroupController@join');
    Route::post('/groups/{groupId}/leave', 'App\Http\Controllers\API\GroupController@leave');
    Route::post('/groups/{groupId}/remove-user/{userId}', 'App\Http\Controllers\API\GroupController@removeUser');
    Route::resource('/groups/{groupId}/chats', 'App\Http\Controllers\API\ChatController');
    Route::post("/account-deletion", "App\Http\Controllers\API\AccountDeletionController");
});

Route::group(['prefix' => 'masters'], function () {
    Route::get('/provinces', 'App\Http\Controllers\API\Master\ProvinceController');
    Route::get('/cities', 'App\Http\Controllers\API\Master\CityController');
});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post("testmail/{email}", function ($email) {
    Mail::raw('Hello World!', function($msg) use($email) {$msg->to($email)->subject('Test Email'); });
    return response()->json(["message" => "Email sent!"]);
});
