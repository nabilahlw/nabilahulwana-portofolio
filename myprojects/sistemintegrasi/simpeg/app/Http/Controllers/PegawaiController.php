<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pegawai;

class PegawaiController extends Controller
{
    public function tampil()
    {
        $data = Pegawai::all();
        return view('pegawai', ['data' => $data]);
    }

    public function simpan(Request $request)
    {
        $request->validate([
            'nip'                => 'required|unique:pegawai,nip',
            'nama'               => 'required|string|max:255',
            'jenis_pegawai'      => 'required|in:Dosen,Tenaga Kependidikan',
            'status_kepegawaian' => 'required|in:Tetap,Kontrak',
            'unit_kerja'         => 'required'
        ]);

        Pegawai::create($request->only([
            'nip', 'nama', 'jenis_pegawai', 'status_kepegawaian', 'unit_kerja'
        ]));

        return redirect()->back()->with('success', 'Data pegawai berhasil ditambahkan');
    }

    public function show($id)
    {
        return response()->json(Pegawai::findOrFail($id));
    }

    public function update(Request $request, $id)
    {
        $pegawai = Pegawai::findOrFail($id);

        $request->validate([
            'nip'                => 'required|unique:pegawai,nip,' . $id . ',id',
            'nama'               => 'required|string|max:255',
            'jenis_pegawai'      => 'required|in:Dosen,Tenaga Kependidikan',
            'status_kepegawaian' => 'required|in:Tetap,Kontrak',
            'unit_kerja'         => 'required'
        ]);

        $pegawai->update($request->only([
            'nip', 'nama', 'jenis_pegawai', 'status_kepegawaian', 'unit_kerja'
        ]));

        return response()->json(['success' => true]);
    }

    public function hapus($id)
    {
        Pegawai::findOrFail($id)->delete();

        return redirect()->back()->with('success', 'Data berhasil dihapus');
    }
}