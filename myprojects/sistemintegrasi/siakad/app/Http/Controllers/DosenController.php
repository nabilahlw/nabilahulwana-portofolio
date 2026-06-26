<?php

namespace App\Http\Controllers;

use App\Models\Pegawai;

class DosenController extends Controller
{
    public function tampil()
    {
        // Mengambil data dosen beserta riwayat jabatannya dari database SIMPEG
        $data = Pegawai::dosen()->with('riwayatJabatan')->orderBy('nama')->get();
        return view('dosen', ['data' => $data]);
    }
}