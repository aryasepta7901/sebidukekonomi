<?php

use App\Http\Controllers\DashboardGroundCheck;
use App\Http\Controllers\GroundCheckController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\KosekaController;


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

// Tambahkan ->name('home') di akhir
Route::get('/', function () {
    return view('landingpage.index');
})->name('home');
Route::resource('/GroundCheck', GroundCheckController::class);
Route::get('/GroundCheck/list-desa/{kdkec}', [GroundCheckController::class, 'getListDesa'])->name('GroundCheck.listDesa');
Route::get('/DashboardGC/export-data', [DashboardGroundCheck::class, 'exportData'])->name('DashboardGC.exportData');
Route::resource('/DashboardGC', DashboardGroundCheck::class);


Route::get('/koseka/{kdkec}', [KosekaController::class, 'showDetail'])->name('koseka.detail');
