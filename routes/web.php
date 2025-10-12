<?php

use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Redirect;

Route::get('/', function ()
{
    return Redirect::Route('dashboard');
});

Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

