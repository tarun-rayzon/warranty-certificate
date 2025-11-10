<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\OrderDetailController;
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

Route::middleware(['auth:sanctum', config('jetstream.auth_session')])->group(function () {

    // dashboard controller
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/feedback', [DashboardController::class, 'feedback'])->name('feedback');
    Route::get('/warranty', [DashboardController::class, 'warranty'])->name('warranty');
    Route::get('/warranty-dashboard', [DashboardController::class, 'warranty_dashboard'])->name('warranty-dashboard');

});
