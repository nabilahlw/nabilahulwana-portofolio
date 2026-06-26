<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PaymentController;

Route::get('/', [PaymentController::class, 'dashboard'])->name('dashboard');
Route::get('/dashboard', [PaymentController::class, 'dashboard'])->name('dashboard');

Route::post('/midtrans/callback', [PaymentController::class, 'callback'])->name('bills.store');
Route::get('/pay/{bill}', [PaymentController::class, 'pay']);
Route::get('/pay', [PaymentController::class, 'tagihan']);
Route::post('/simpantagihan', [PaymentController::class, 'simpan']);
Route::post('/bayartagihan/{id}', [PaymentController::class, 'bayar']);
Route::post('/updatetagihan/{id}', [PaymentController::class, 'update']);
Route::delete('/hapustagihan/{id}', [PaymentController::class, 'hapus']);
Route::get('/cekstatus/{id}', [PaymentController::class, 'cekStatus']);



