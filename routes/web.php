<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\NasabahDashboardController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\SetoranController;
use App\Http\Controllers\TransaksiController;
use App\Http\Controllers\TarikController;
use App\Http\Controllers\NasabahController;
use App\Http\Controllers\LaporanController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\SampahController;

Route::get('/', function () {
    return view('welcome');
});
Route::get('/login', function () {
    return view('auth.login');
})->name('login');


Route::post('/login', [AuthController::class, 'login'])->name('login');
// Route::group(['middleware' => ['auth', 'check_role:admin,nasabah']], function () {
// Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
// });
// Route::group(['middleware' => ['auth', 'check_role:nasabah']], function () {
//     Route::get('/dashboard', fn() => 'halaman nasbah');
// });
// Route::group(['middleware' => ['auth', 'check_role:admin']], function () {
//     Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
// });
//Route::get('/dashboard', [DashboardController::class, 'index'])->middleware('auth')->name('dashboard');
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
//Route::get('/nasabah', fn() => 'halaman nasbah');
// Route::middleware(['auth'])->group(function () {
//     Route::get('/dashboard', [DashboardController::class, 'redirectToDashboard'])->name('dashboard');
// });

// Route khusus untuk masing-masing role
Route::group(['middleware' => ['auth', 'check_role:nasabah']], function () {
    Route::get('/NasabahDashboard', [NasabahDashboardController::class, 'index'])->name('nasabah.dashboard');
});

Route::group(['middleware' => ['auth', 'check_role:admin']], function () {
    Route::get('/AdminDashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');
});

// contoh (opsional, sesuaikan dengan project-mu)
Route::resource('setoran', SetoranController::class);   // setoran.create, setoran.index, ...
Route::resource('tarik', TarikController::class);       // tarik.create, ...
Route::get('/saldo', [TransaksiController::class, 'saldo'])->name('saldo.index');

Route::resource('nasabah', NasabahController::class);   // nasabah.index, nasabah.create, ...
Route::get('/laporan', [LaporanController::class, 'index'])->name('laporan.index');

// Laporan: semua role login bisa akses
Route::middleware(['auth'])->group(function () {
    Route::get('/laporan/setor', [LaporanController::class, 'setor'])->name('laporan.setor');
    Route::get('/laporan/tarik', [LaporanController::class, 'tarik'])->name('laporan.tarik');
    Route::get('/laporan/saldo', [LaporanController::class, 'saldo'])->name('laporan.saldo');
});

//CRUD

Route::middleware(['auth'])->group(function () {
    Route::resource('sampah', SampahController::class);
    Route::resource('nasabah', NasabahController::class);
    Route::resource('setoran', SetoranController::class);
    Route::resource('tarik', TarikController::class);
    Route::resource('transaksi', TransaksiController::class);
    // Tambahan route untuk saldo
    Route::get('transaksi/saldo', [TransaksiController::class, 'saldo'])->name('transaksi.saldo');
});

// Setoran
Route::get('setoran/report', [App\Http\Controllers\SetoranController::class, 'report'])->name('setoran.report');

// Tarik
Route::get('tarik/report', [App\Http\Controllers\TarikController::class, 'report'])->name('tarik.report');

// Transaksi
Route::get('transaksi/report', [App\Http\Controllers\TransaksiController::class, 'report'])->name('transaksi.report');

Route::get('tarik/report', [App\Http\Controllers\TarikController::class, 'report'])->name('tarik.report');
Route::get('transaksi/report', [App\Http\Controllers\TransaksiController::class, 'report'])->name('transaksi.report');

// routes/web.php
Route::resource('sampah', SampahController::class)->middleware('auth');
// Route::get('/tarik/create', [TarikController::class, 'create'])->name('tarik.create');
