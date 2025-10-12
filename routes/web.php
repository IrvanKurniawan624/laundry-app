<?php

use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Redirect;

use App\Http\Controllers\Admin\PegawaiController;

Route::get('/', function ()
{
    return Redirect::Route('dashboard');
});

Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

Route::prefix('admin')
    ->name('admin.')
    ->group(function () {
        Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

        Route::resource('pegawai', PegawaiController::class);
        // Route::resource('pelanggan', PelangganController::class);
        // Route::resource('kurir', KurirController::class);
        // Route::resource('snack', SnackController::class);
    });