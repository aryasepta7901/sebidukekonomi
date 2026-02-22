<?php

use App\Http\Controllers\DashboardGroundCheck;
use App\Http\Controllers\GroundCheckController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\KosekaController;
use App\Http\Controllers\LandingPageController;
use Illuminate\Support\Facades\Cache;

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


Route::resource('/', LandingPageController::class);
Route::resource('/GroundCheck', GroundCheckController::class);
Route::get('/GroundCheck/list-desa/{kdkec}', [GroundCheckController::class, 'getListDesa'])->name('GroundCheck.listDesa');
Route::get('/DashboardGC/export-data', [DashboardGroundCheck::class, 'exportData'])->name('DashboardGC.exportData');
Route::resource('/DashboardGC', DashboardGroundCheck::class);
Route::get('/updaterekap', function () {
    Cache::forget('rekap_sheets_koseka');
    return "Cache dihapus! Silakan buka kembali halaman utama untuk memicu download data terbaru.";
});

Route::get('/koseka/{kdkec}', [KosekaController::class, 'showDetail'])->name('koseka.detail');
