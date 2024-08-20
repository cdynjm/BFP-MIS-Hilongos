<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Pages\Auth\LoginController;
use App\Http\Controllers\Pages\Applicant\DashboardController;
use App\Http\Controllers\Pages\Applicant\InspectionController;

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

Route::group(['middleware' => 'auth'], function () {

	Route::group(['middleware' => 'applicant'], function () {
		Route::group(['prefix' => 'applicant'], function () {

			Route::get('/dashboard', [DashboardController::class, 'dashboard'])->name('applicant.dashboard');
            Route::post('/dashboard', [DashboardController::class, 'createRequestInspection'])->name('applicant.create-request-inspection');

            Route::get('/inspections/{id}', [InspectionController::class, 'inspections'])->name('applicant.inspections');
            Route::delete('/inspections', [InspectionController::class, 'deleteInspection'])->name('applicant.delete-inspection');

        });
	});
});