<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PegawaiController;
use App\Http\Controllers\JabatanController;

Route::get('/', [PegawaiController::class, 'tampil']);
Route::get('/pegawai', [PegawaiController::class, 'tampil']);
Route::post('/pegawai/simpan', [PegawaiController::class, 'simpan']);
Route::get('/pegawai/{id}', [PegawaiController::class, 'show']);
Route::post('/pegawai/{id}', [PegawaiController::class, 'update']);
Route::post('/pegawai/hapus/{id}', [PegawaiController::class, 'hapus']); // sebelumnya GET, sekarang POST

Route::get('/jabatan', [JabatanController::class, 'tampil']);
Route::post('/jabatan/simpan', [JabatanController::class, 'simpan']);
Route::get('/jabatan/{id}', [JabatanController::class, 'show']);
Route::post('/jabatan/{id}', [JabatanController::class, 'update']);
Route::delete('/jabatan/hapus/{id}', [JabatanController::class, 'hapus']);

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


