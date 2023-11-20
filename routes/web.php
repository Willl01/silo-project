<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ObatController;
use App\Http\Controllers\DokterController;
use App\Http\Controllers\StokController;
use App\Http\Controllers\StokOutController;
use App\Http\Controllers\ResepController;
use App\Http\Controllers\RiwayatController;

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

Route::get('/', function () {
    return view('dokter.index');
})->middleware('auth', 'checkRole:dokter,admin');

Route::get('/admin', [DashboardController::class, 'index'])
    ->middleware(['auth', 'checkRole:admin']);


Auth::routes();
Route::resource('/admin/obat', ObatController::class)->middleware('auth', 'checkRole:admin')->names([
    'edit' => 'obat.edit',
]);
Route::get('obat/delete/{id_obat}', [ObatController::class, 'delete'])->name('delete');

Route::resource('/', DokterController::class)->middleware('auth', 'checkRole:admin');

Route::post('/admin/stokin/tambah', [StokController::class, 'tambahStok'] )->middleware('auth', 'checkRole:admin');
Route::resource('/admin/stokin', StokController::class)->middleware('auth', 'checkRole:admin');

Route::resource('/admin/stokout', StokOutController::class)->middleware('auth', 'checkRole:admin');

Route::get('riwayat', [ResepController::class, 'index']);

Route::get('riwayatresep', [RiwayatController::class, 'index']);

