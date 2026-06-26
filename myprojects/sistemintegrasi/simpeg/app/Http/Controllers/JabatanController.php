<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Jabatan;
use App\Models\Pegawai;

class JabatanController extends Controller
{
    public function tampil()
    {
        $data = Jabatan::with('pegawai')->orderByDesc('tanggal_pengangkatan')->get();
        $dosen = Pegawai::dosen()->orderBy('nama')->get();

        return view('jabatan', [
            'data' => $data,
            'dosen' => $dosen,
        ]);
    }

    public function simpan(Request $request)
    {
        $request->validate([
            'pegawai_id'           => 'required|exists:pegawai,id',
            'nama_jabatan'         => 'required|string|max:100',
            'tanggal_pengangkatan' => 'required|date',
            'tmt_akhir'            => 'nullable|date|after_or_equal:tanggal_pengangkatan',
        ]);

        Jabatan::create($request->only([
            'pegawai_id', 'nama_jabatan', 'tanggal_pengangkatan', 'tmt_akhir'
        ]));

        return redirect()->back()->with('success', 'Data jabatan berhasil ditambahkan');
    }

    public function show($id)
    {
        return response()->json(Jabatan::findOrFail($id));
    }

   public function update(Request $request, $id)
{
    $jabatan = Jabatan::findOrFail($id);
    $jabatan->update([
        'pegawai_id'           => $request->pegawai_id,
        'nama_jabatan'         => $request->nama_jabatan,
        'tanggal_pengangkatan' => $request->tanggal_pengangkatan,
        'tmt_akhir'            => $request->tmt_akhir ?: null,
    ]);
    return redirect()->back()->with('success', 'Jabatan berhasil diperbarui!');
}

    public function hapus($id)
    {
        Jabatan::findOrFail($id)->delete();

        return redirect()->back()->with('success', 'Data jabatan berhasil dihapus');
    }
}