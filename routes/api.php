<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PaymentGatewayController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

// ================================
// USER (HARUS LOGIN)
// ================================
Route::middleware('auth:sanctum')->group(function () {

    // Create deposit (membuat transaksi)
    Route::post('/jayapay/deposit', [PaymentGatewayController::class, 'create']);

    // Cek status transaksi manual
    Route::get('/jayapay/status', [PaymentGatewayController::class, 'statusPayment']);
});

// ================================
// CALLBACK DARI JAYAPAY (TIDAK PERLU LOGIN)
// ================================

// WAJIB diaktifkan agar saldo user masuk otomatis
Route::post('/jayapay/callback', [PaymentGatewayController::class, 'callback'])
    ->name('jayapay.callback');
