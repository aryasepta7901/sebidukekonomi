<?php

use App\Http\Controllers\DashboardGroundCheck;
use App\Http\Controllers\GroundCheckController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\KosekaController;
use App\Http\Controllers\LandingPageController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::get('/', [LandingPageController::class, 'index']);
Route::resource('/GroundCheck', GroundCheckController::class);
Route::get('/GroundCheck/list-desa/{kdkec}', [GroundCheckController::class, 'getListDesa'])->name('GroundCheck.listDesa');
Route::get('/DashboardGC/export-data', [DashboardGroundCheck::class, 'exportData'])->name('DashboardGC.exportData');
Route::resource('/DashboardGC', DashboardGroundCheck::class);
Route::get('/updaterekap', [LandingPageController::class, 'updateRekap']);

Route::get('/koseka/{kdkec}', [KosekaController::class, 'showDetail'])->name('koseka.detail');

Route::view('/MonitoringLapangan', 'backend.monitoring');
Route::view('/EarlyWarningSystem', 'backend.earlywarningsystem');
Route::view('/Anomali', 'backend.anomali');
