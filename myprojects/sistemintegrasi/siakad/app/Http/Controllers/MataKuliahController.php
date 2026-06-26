<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MataKuliah;
use App\Models\Pegawai;

class MataKuliahController extends Controller
{
    public function tampil()
    {
        $data = MataKuliah::with('dosenPengampu')->orderBy('nama_mk')->get();
        $dosen = Pegawai::dosen()->orderBy('nama')->get();

        return view('mata_kuliah', [
            'data' => $data,
            'dosen' => $dosen,
        ]);
    }

    public function simpan(Request $request)
    {
        $request->validate([
            'kode_mk'           => 'required|unique:mata_kuliah,kode_mk',
            'nama_mk'           => 'required|string|max:255',
            'sks'               => 'required|integer|min:1|max:6',
            'semester'          => 'nullable|string|max:20',
            'dosen_pengampu_id' => 'nullable|exists:simpeg.pegawai,id',
        ]);

        MataKuliah::create($request->only([
            'kode_mk', 'nama_mk', 'sks', 'semester', 'dosen_pengampu_id'
        ]));

        return redirect()->back()->with('success', 'Data mata kuliah berhasil ditambahkan');
    }

    public function show($id)
{
    return response()->json(MataKuliah::findOrFail($id));
}

public function update(Request $request, $id)
{
    $mk = MataKuliah::findOrFail($id);

    $mk->update([
        'kode_mk'           => $request->kode_mk,
        'nama_mk'           => $request->nama_mk,
        'sks'               => $request->sks,
        'semester'          => $request->semester,
        'dosen_pengampu_id' => $request->dosen_pengampu_id,
    ]);

    return redirect()->back()->with('success', 'Data mata kuliah berhasil diperbarui');
}

    public function hapus($id)
    {
        MataKuliah::findOrFail($id)->delete();
        return redirect()->back()->with('success', 'Data mata kuliah berhasil dihapus');
    }
}