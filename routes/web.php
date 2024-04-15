<?php

use App\Http\Controllers\Front\Auth\ResetPasswordController;
use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});
Volt::route('/', 'fronts.home')->name('home');
Volt::route('password-reset/{token}', 'fronts.auth.password-reset')->name('password.reset');
Volt::route('password-reset-status', 'fronts.auth.password-reset-status')->name('password.reset.status');
Volt::route("privacy-policy", "fronts.privacy-policy")->name("privacy-policy");
// Route::get("reset-password/{token}", [ResetPasswordController::class, "getResetPassword"])->name("password.reset");
// Route::post("reset-password", [ResetPasswordController::class, "postResetPassword"])->name("password.reset.post");
// Route::get("reset-password-status", [ResetPasswordController::class, "getPasswordResetStatus"])->name("password.reset.status");
