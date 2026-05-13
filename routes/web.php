<?php

use App\Http\Controllers\DashboardGroundCheck;
use App\Http\Controllers\GroundCheckController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\KosekaController;
use App\Http\Controllers\LandingPageController;
use App\Http\Controllers\BeritaKegiatanController;
use App\Http\Controllers\LoginController;

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
// --- ROUTE GUEST ---
Route::middleware(['guest'])->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);
    Route::get('auth/google', [LoginController::class, 'redirectToGoogle'])->name('google.login');
    Route::get('auth/google/callback', [LoginController::class, 'handleGoogleCallback']);
});

// --- ROUTE AUTH ---
Route::middleware(['auth', 'role'])->group(function () {

    // Halaman khusus untuk user yang belum di-approve
    Route::get('/waiting-approval', function () {
        return view('auth.waiting');
    });

    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

    // --- AREA KHUSUS ROLE TERTENTU (Sudah Approve) ---
    // Dashboard Utama (Hanya bisa diakses role yang sudah diapprove)
    Route::get('/backend', function () {
        return view('backend.backend');
    })->middleware('role:admin,operator,pml,pcl,koseka,viewer');

    // Dashboard Ground Check (Bisa dilihat semua yang sudah approve)
    Route::resource('/DashboardGC', DashboardGroundCheck::class)->middleware('role:admin,operator,pml,pcl,koseka,viewer');
    Route::get('/DashboardGC/export-data', [DashboardGroundCheck::class, 'exportData'])->name('DashboardGC.exportData');

    // Route Berita (Misal: Hanya Admin dan Operator yang bisa kelola)
    Route::middleware(['role:admin,operator'])->group(function () {
        Route::resource('/backend/berita', BeritaKegiatanController::class);
    });

    // Helper untuk AJAX/Peta (Bisa semua role approve)
    Route::get('/GroundCheck/list-desa/{kdkec}', [GroundCheckController::class, 'getListDesa'])->name('GroundCheck.listDesa');

    Route::get('/', function () {
        return redirect('/backend');
    });
});

Route::get('/', [LandingPageController::class, 'index']);
Route::resource('/GroundCheck', GroundCheckController::class);
Route::get('/updaterekap', [LandingPageController::class, 'updateRekap']);

Route::get('/koseka/{kdkec}', [KosekaController::class, 'showDetail'])->name('koseka.detail');

Route::view('/MonitoringLapangan', 'backend.monitoring');
Route::view('/EarlyWarningSystem', 'backend.earlywarningsystem');
Route::view('/Anomali', 'backend.anomali');
