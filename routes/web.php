<?php

use App\Http\Controllers\GroundCheckController;
use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('landingpage.index');
});
Route::resource('/GroundCheck', GroundCheckController::class);
Route::get('/GroundCheck/list-desa/{kdkec}', [GroundCheckController::class, 'getListDesa'])->name('GroundCheck.listDesa');
