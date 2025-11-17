<?php

use App\Http\Controllers\CustomerDashboardController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FtrFileController;
use App\Http\Controllers\OtpController;
use App\Http\Controllers\QcApprovalController;
use App\Http\Controllers\WarrantyPublicController;
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

Route::get('/', [WarrantyPublicController::class, 'create'])->name('public.request.create');
Route::post('/request/preview', [WarrantyPublicController::class, 'preview'])->name('public.request.preview'); // optional step
Route::post('/request/submit', [WarrantyPublicController::class, 'submit'])->name('public.request.submit');
Route::post('/serial/check', [WarrantyPublicController::class, 'checkSerial'])->name('serial.check');
Route::post('/otp/send', [OtpController::class, 'send'])->name('otp.send');
Route::post('/otp/verify', [OtpController::class, 'verify'])->name('otp.verify');

Route::middleware(['auth:sanctum', config('jetstream.auth_session')])->group(function () {

    // dashboard controller
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::resource('ftr-files', FtrFileController::class);

    // Warranty Requests
    Route::get('warranty-requests', [QcApprovalController::class, 'index'])->name('warranty-requests.index');
});


// Temporary Dashboard (email-otp session)
Route::middleware('temp.auth')->prefix('customer')->group(function () {
    Route::get('/dashboard', [CustomerDashboardController::class, 'index'])->name('customer.dashboard');
    Route::post('/logout', [CustomerDashboardController::class, 'logout'])->name('customer.logout');
});
