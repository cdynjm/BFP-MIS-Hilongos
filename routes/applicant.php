<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Pages\Auth\LoginController;
use App\Http\Controllers\Pages\Applicant\DashboardController;
use App\Http\Controllers\Pages\Applicant\InspectionController;
use App\Http\Controllers\Pages\Applicant\RequestInspectionController;

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

    Route::group(['middleware' => 'verified'], function () {

        Route::group(['middleware' => 'applicant'], function () {
            Route::group(['prefix' => 'applicant'], function () {

                Route::get('/dashboard', [DashboardController::class, 'dashboard'])->name('applicant.dashboard');
                Route::post('/dashboard', [DashboardController::class, 'createRequestInspection'])->name('applicant.create-request-inspection');

                Route::get('/inspections/{id}', [InspectionController::class, 'inspections'])->name('applicant.inspections');
                Route::delete('/inspections', [InspectionController::class, 'deleteInspection'])->name('applicant.delete-inspection');

                Route::get('/request-inspection', [RequestInspectionController::class, 'requestInspection'])->name('applicant.request-inspection');
                Route::post('/fsec', [RequestInspectionController::class, 'createFSEC'])->name('applicant.create-fsec');
                Route::post('/fsic-occupancy', [RequestInspectionController::class, 'createFSICOccupancy'])->name('applicant.create-fsic-occupancy');
                Route::post('/fsic-business', [RequestInspectionController::class, 'createFSICBusiness'])->name('applicant.create-fsic-business');

                Route::get('/certificate/{id}', [InspectionController::class, 'certificate']);
            });
        });
        
    });
});