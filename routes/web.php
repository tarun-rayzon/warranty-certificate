<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FtrFileController;
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

Route::get('/', [DashboardController::class, 'warranty'])->name('warranty');

Route::middleware(['auth:sanctum', config('jetstream.auth_session')])->group(function () {

    // dashboard controller
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::resource('ftr-files', FtrFileController::class);
});

// Route::get('/warranty-dashboard', [DashboardController::class, 'warranty_dashboard'])->name('warranty-dashboard');
