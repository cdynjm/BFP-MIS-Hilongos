<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Pages\Auth\LoginController;
use App\Http\Controllers\Pages\Admin\DashboardController;
use App\Http\Controllers\Pages\Admin\PersonnelController;
use App\Http\Controllers\Pages\Admin\FireIncidentController;
use App\Http\Controllers\Pages\Admin\InspectionController;
use App\Http\Controllers\Pages\Admin\SMSController;

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

	Route::group(['middleware' => 'admin'], function () {
		Route::group(['prefix' => 'admin'], function () {

			Route::get('/dashboard', [DashboardController::class, 'dashboard'])->name('admin.dashboard');
			Route::get('/dashboard/search/', [DashboardController::class, 'searchYear'])->name('admin.search-year-dashboard');

			Route::get('/personnel', [PersonnelController::class, 'personnel'])->name('admin.personnel');
			Route::post('/personnel', [PersonnelController::class, 'createPersonnel'])->name('admin.create-personnel');
			Route::patch('/personnel', [PersonnelController::class, 'updatePersonnel'])->name('admin.update-personnel');
			Route::delete('/personnel', [PersonnelController::class, 'deletePersonnel'])->name('admin.delete-personnel');

			Route::get('/fire-incident', [FireIncidentController::class, 'fireIncident'])->name('admin.fire-incident');
			Route::get('/fire-incident/search/', [FireIncidentController::class, 'searchYear'])->name('admin.search-year');
			Route::post('/fire-incident', [FireIncidentController::class, 'createFireIncident'])->name('admin.create-fire-incident');
			Route::patch('/fire-incident', [FireIncidentController::class, 'updateFireIncident'])->name('admin.update-fire-incident');
			Route::delete('/fire-incident', [FireIncidentController::class, 'deleteFireIncident'])->name('admin.delete-fire-incident');

			Route::get('/inspections/{id}', [InspectionController::class, 'inspections'])->name('admin.inspections');
			Route::patch('/inspections', [InspectionController::class, 'scheduleInspection'])->name('admin.schedule-inspection');

			Route::get('/sms-token', [SMSController::class, 'SMS'])->name('admin.sms-token');
			Route::patch('/sms-token', [SMSController::class, 'updateSMS'])->name('admin.update-sms-token');

		});
	});
});