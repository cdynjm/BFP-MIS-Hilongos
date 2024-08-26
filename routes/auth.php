<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Pages\Auth\LoginController;
use App\Http\Controllers\Pages\Auth\RegisterController;
use App\Http\Controllers\Pages\Auth\PasswordResetController;
use App\Http\Controllers\Layouts\NavbarController;
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

Route::group(['middleware' => 'guest'], function () {
	Route::get('/', [LoginController::class, 'login'])->name('login');
	Route::get('/login', [LoginController::class, 'login'])->name('login');
	Route::post('/authenticate', [LoginController::class, 'authenticate'])->name('login.authenticate');

    Route::get('/register', [RegisterController::class, 'register'])->name('register');
    Route::post('/register', [RegisterController::class, 'authenticate'])->name('register.authenticate');

    Route::get('/password/reset', [PasswordResetController::class, 'request'])->name('password.request');
    Route::post('/password/email', [PasswordResetController::class, 'email'])->name('password.email');
    Route::get('/password/reset/{token}', [PasswordResetController::class, 'reset'])->name('password.reset');
    Route::post('/password/reset', [PasswordResetController::class, 'update'])->name('password.update');

});

Route::group(['middleware' => 'auth'], function () {
    Route::get('/notification', [NavbarController::class, 'notification'])->name('notification');
    Route::post('/update-profile', [NavbarController::class, 'updateProfile'])->name('update-profile');
    Route::get('/logout', [LoginController::class, 'destroy'])->name('logout');
});

?>