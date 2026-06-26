<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Mahasiswa;
use App\Models\Pegawai;

class MahasiswaController extends Controller
{
    public function index()
    {
        return view('dashboard');
    }

    public function tampil()
    {
        $data  = Mahasiswa::with('dosenWali')->get();
        $dosen = Pegawai::dosen()->orderBy('nama')->get();

        return view('mahasiswa', [
            'data'  => $data,
            'dosen' => $dosen,
        ]);
    }

    public function simpan(Request $request)
    {
        $request->validate([
            'nim'   => 'required|unique:mahasiswa,nim',
            'nama'  => 'required|string|max:255',
            'prodi' => 'required',
        ]);

        Mahasiswa::create([
            'nim'           => $request->nim,
            'nama'          => $request->nama,
            'id_prodi'      => $request->prodi,
            'kelas'         => $request->kelas,
            'status_aktif'  => $request->status_aktif ?? 'Aktif',
            'dosen_wali_id' => $request->dosen_wali_id,
        ]);

        return redirect()->back()->with('success', 'Data mahasiswa berhasil ditambahkan');
    }

    public function show($id)
    {
        return response()->json(Mahasiswa::findOrFail($id));
    }

    public function update(Request $request, $id)
    {
        $mhs = Mahasiswa::findOrFail($id);

        $mhs->update([
            'nim'           => $request->nim,
            'nama'          => $request->nama,
            'id_prodi'      => $request->prodi,
            'kelas'         => $request->kelas,
            'status_aktif'  => $request->status_aktif ?? 'Aktif',
            'dosen_wali_id' => $request->dosen_wali_id,
        ]);

        return redirect()->back()->with('success', 'Data mahasiswa berhasil diperbarui');
    }

    public function hapus($id)
    {
        Mahasiswa::findOrFail($id)->delete();

        return redirect()->back()->with('success', 'Data berhasil dihapus');
    }
}