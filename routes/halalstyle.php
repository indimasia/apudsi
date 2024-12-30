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
        Route::post('/logout', 'App\Http\Controllers\API\Auth\V2\LogoutController')->middleware('auth:sanctum');
        Route::post("/forgot-password", "App\Http\Controllers\API\Auth\V2\ForgotPasswordController");
    });

    // Route::group(['prefix' => 'v3'], function() {
    //     Route::post('/register', 'App\Http\Controllers\API\Auth\V2\RegisterController');
    //     Route::post('/login', 'App\Http\Controllers\API\Auth\V2\LoginController');
    //     Route::post('/logout', 'App\Http\Controllers\API\Auth\V2\LogoutController')->middleware('auth:sanctum');
    //     Route::post("/forgot-password", "App\Http\Controllers\API\Auth\V2\ForgotPasswordController");
    // });
});

Route::middleware('auth:sanctum')->group(function () {
    Route::post("/update-location", "App\Http\Controllers\API\UpdateLocationController");
    Route::get('/profile', 'App\Http\Controllers\API\ProfileController@getProfile');
    Route::post('/profile', 'App\Http\Controllers\API\ProfileController@postProfile');

    Route::resource('/articles', 'App\Http\Controllers\API\ArticleController');
    Route::resource('/sos', 'App\Http\Controllers\API\SosController');
    
    Route::resource('/groups', 'App\Http\Controllers\API\GroupController');
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
