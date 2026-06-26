<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MahasiswaController;
use App\Http\Controllers\DosenController;
use App\Http\Controllers\MataKuliahController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\DashboardController;

Route::get('/', [DashboardController::class, 'index']);
Route::get('/dashboard', [DashboardController::class, 'index']);

// Mahasiswa (CRUD)
Route::get('/mahasiswa', [MahasiswaController::class, 'tampil']);
Route::post('/mahasiswa/simpan', [MahasiswaController::class, 'simpan']);
Route::get('/mahasiswa/show/{id}', [MahasiswaController::class, 'show']);
Route::post('/mahasiswa/update/{id}', [MahasiswaController::class, 'update']);
Route::delete('/mahasiswa/hapus/{id}', [MahasiswaController::class, 'hapus']);

// Mata Kuliah (CRUD)
Route::get('/matakuliah', [MataKuliahController::class, 'tampil']);
Route::post('/matakuliah/simpan', [MataKuliahController::class, 'simpan']);
Route::get('/matakuliah/{id}', [MataKuliahController::class, 'show']);
Route::post('/matakuliah/{id}', [MataKuliahController::class, 'update']);
Route::delete('/matakuliah/hapus/{id}', [MataKuliahController::class, 'hapus']);

// Dosen (read-only, dari SIMPEG)
Route::get('/dosen', [DosenController::class, 'tampil']);

// Pembayaran (read-only, dari SIKEU)
Route::get('/payment', [PaymentController::class, 'tampil']);
// Route::get('/dashboard', [SiswaController::class, 'index']);
// Route::get('/', [SiswaController::class, 'index']);
// Route::get('/siswa', [SiswaController::class, 'tampil']);
// Route::get('/tambah', [SiswaController::class, 'tambah']);
// Route::post('/simpan', [SiswaController::class, 'simpan']);
// Route::get('/siswa/ubah/{nisn}', [SiswaController::class, 'ubah']);
// Route::post('/ubah', [SiswaController::class, 'edit']);
// Route::get('/siswa/hapus/{nisn}', [SiswaController::class, 'hapus']);
// Route::get('/pdf', [SiswaController::class, 'pdf']);
// Route::get('/excel', [SiswaController::class, 'excel']);
// Route::get('/csv', [SiswaController::class, 'exportCsv']);


