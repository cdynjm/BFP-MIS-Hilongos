<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Pages\Auth\LoginController;
use App\Http\Controllers\Pages\Personnel\DashboardController;
use App\Http\Controllers\Pages\Personnel\InspectionController;
use App\Http\Controllers\Pages\Personnel\FireIncidentController;

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

        Route::group(['middleware' => 'personnel'], function () {
            Route::group(['prefix' => 'personnel'], function () {

                Route::get('/dashboard', [DashboardController::class, 'dashboard'])->name('personnel.dashboard');
                Route::get('/dashboard/search/', [DashboardController::class, 'searchYear'])->name('personnel.search-year-dashboard');

                Route::get('/inspections/{id}', [InspectionController::class, 'inspections'])->name('personnel.inspections');
                Route::patch('/inspections', [InspectionController::class, 'completeInspection'])->name('personnel.complete-inspection');
                Route::post('/upload-form', [InspectionController::class, 'uploadForm'])->name('personnel.upload-form');
                Route::delete('/delete-form', [InspectionController::class, 'deleteForm'])->name('personnel.delete-form');
                Route::patch('/generate-certificate', [InspectionController::class, 'generateCertificate'])->name('personnel.generate-certificate');
                Route::get('/inspections/search/{id}', [InspectionController::class, 'searchYearMonth'])->name('personnel.search-year-month');

                Route::get('/fire-incident', [FireIncidentController::class, 'fireIncident'])->name('personnel.fire-incident');
                Route::get('/fire-incident/search/', [FireIncidentController::class, 'searchYear'])->name('personnel.search-year');
                Route::post('/fire-incident', [FireIncidentController::class, 'createFireIncident'])->name('personnel.create-fire-incident');
                Route::patch('/fire-incident', [FireIncidentController::class, 'updateFireIncident'])->name('personnel.update-fire-incident');
                Route::delete('/fire-incident', [FireIncidentController::class, 'deleteFireIncident'])->name('personnel.delete-fire-incident');

                Route::get('/certificate/{id}', [InspectionController::class, 'certificate']);
            });
        });
    });
});