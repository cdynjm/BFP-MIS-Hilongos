<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Pages\Auth\LoginController;
use App\Http\Controllers\Pages\Admin\DashboardController;
use App\Http\Controllers\Pages\Admin\PersonnelController;
use App\Http\Controllers\Pages\Admin\FireIncidentController;
use App\Http\Controllers\Pages\Admin\InspectionController;
use App\Http\Controllers\Pages\Admin\SettingsController;
use App\Http\Controllers\Pages\Admin\ApplicantController;

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
			Route::post('/update-personnel', [PersonnelController::class, 'updatePersonnel'])->name('admin.update-personnel');
			Route::delete('/personnel', [PersonnelController::class, 'deletePersonnel'])->name('admin.delete-personnel');

			Route::get('/fire-incident', [FireIncidentController::class, 'fireIncident'])->name('admin.fire-incident');
			Route::get('/fire-incident/search/', [FireIncidentController::class, 'searchYear'])->name('admin.search-year');
			Route::post('/fire-incident', [FireIncidentController::class, 'createFireIncident'])->name('admin.create-fire-incident');
			Route::patch('/fire-incident', [FireIncidentController::class, 'updateFireIncident'])->name('admin.update-fire-incident');
			Route::delete('/fire-incident', [FireIncidentController::class, 'deleteFireIncident'])->name('admin.delete-fire-incident');

			Route::get('/inspections/{id}', [InspectionController::class, 'inspections'])->name('admin.inspections');
			Route::patch('/inspections', [InspectionController::class, 'scheduleInspection'])->name('admin.schedule-inspection');
			Route::patch('/complete-inspections', [InspectionController::class, 'completeInspection'])->name('admin.complete-inspection');
            Route::post('/upload-form', [InspectionController::class, 'uploadForm'])->name('admin.upload-form');
            Route::delete('/delete-form', [InspectionController::class, 'deleteForm'])->name('admin.delete-form');
			Route::patch('/reschedule', [InspectionController::class, 'reschedule'])->name('admin.reschedule');
			Route::patch('/generate-certificate', [InspectionController::class, 'generateCertificate'])->name('admin.generate-certificate');
			Route::get('/inspections/search/{id}', [InspectionController::class, 'searchYearMonth'])->name('admin.search-year-month');

			Route::get('/settings', [SettingsController::class, 'settings'])->name('admin.settings');
			Route::patch('/sms-token', [SettingsController::class, 'updateSMS'])->name('admin.update-sms-token');
			Route::patch('/cert-info', [SettingsController::class, 'updateCertInfo'])->name('admin.update-cert-info');

			Route::get('/applicants-users', [ApplicantController::class, 'applicants'])->name('admin.applicants-users');
			Route::get('/applicant-certificate-history/{id}', [ApplicantController::class, 'applicantsRecords'])->name('admin.applicants-records');

			
			Route::get('/certificate/{id}', [InspectionController::class, 'certificate']);

		});
	});
});