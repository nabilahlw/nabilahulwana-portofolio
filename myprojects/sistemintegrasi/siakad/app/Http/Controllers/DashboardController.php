<?php

namespace App\Http\Controllers;

use App\Models\Mahasiswa;
use App\Models\Pegawai;
use App\Models\Payment;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // ===== 1. Total Mahasiswa =====
        $totalMahasiswa = Mahasiswa::count();

        // ===== 2. Rasio Gender =====
        $genderCounts = Mahasiswa::selectRaw('gender, COUNT(*) as total')
            ->whereNotNull('gender')
            ->groupBy('gender')
            ->pluck('total', 'gender');

        $totalGender = $genderCounts->sum();
        $jumlahLaki  = $genderCounts->get('L', 0);
        $jumlahPerempuan = $genderCounts->get('P', 0);
        $persenLaki  = $totalGender > 0 ? round($jumlahLaki / $totalGender * 100, 1) : 0;
        $persenPerempuan = $totalGender > 0 ? round($jumlahPerempuan / $totalGender * 100, 1) : 0;

        // ===== 3. Per Program Studi =====
        $prodiMap = [1 => 'Sistem Informasi', 2 => 'Teknik Informatika', 3 => 'Teknik Komputer', 4 => 'TRPL'];
        $prodiCounts = Mahasiswa::selectRaw('id_prodi, COUNT(*) as total')
            ->groupBy('id_prodi')
            ->pluck('total', 'id_prodi');

        $prodiLabels = [];
        $prodiData = [];
        $prodiPersen = [];
        foreach ($prodiMap as $id => $nama) {
            $count = $prodiCounts->get($id, 0);
            $prodiLabels[] = $nama;
            $prodiData[] = $count;
            $prodiPersen[] = $totalMahasiswa > 0 ? round($count / $totalMahasiswa * 100, 1) : 0;
        }

        // ===== 4. Per Kelas =====
        $kelasCounts = Mahasiswa::selectRaw('kelas, COUNT(*) as total')
            ->whereNotNull('kelas')
            ->groupBy('kelas')
            ->orderBy('kelas')
            ->pluck('total', 'kelas');

        $kelasLabels = $kelasCounts->keys()->toArray();
        $kelasData = $kelasCounts->values()->toArray();
        $kelasPersen = array_map(function ($v) use ($totalMahasiswa) {
            return $totalMahasiswa > 0 ? round($v / $totalMahasiswa * 100, 1) : 0;
        }, $kelasData);

        // ===== 5. Status Mahasiswa =====
        $statusCounts = Mahasiswa::selectRaw('status_aktif, COUNT(*) as total')
            ->whereNotNull('status_aktif')
            ->groupBy('status_aktif')
            ->pluck('total', 'status_aktif');

        $statusLabels = $statusCounts->keys()->toArray();
        $statusData = $statusCounts->values()->toArray();
        $statusPersen = array_map(function ($v) use ($totalMahasiswa) {
            return $totalMahasiswa > 0 ? round($v / $totalMahasiswa * 100, 1) : 0;
        }, $statusData);

        // ===== 6. Total Dosen =====
        $totalDosen = Pegawai::where('jenis_pegawai', 'Dosen')->count();

        // ===== 7. Status Tagihan Mahasiswa =====
        $tagihanCounts = Payment::selectRaw('status_bayar, COUNT(*) as total')
            ->groupBy('status_bayar')
            ->pluck('total', 'status_bayar');

        $totalTagihan = $tagihanCounts->sum();
        $tagihanLabels = $tagihanCounts->keys()->toArray();
        $tagihanData = $tagihanCounts->values()->toArray();
        $tagihanPersen = array_map(function ($v) use ($totalTagihan) {
            return $totalTagihan > 0 ? round($v / $totalTagihan * 100, 1) : 0;
        }, $tagihanData);

        return view('dashboard', [
            'totalMahasiswa'   => $totalMahasiswa,
            'jumlahLaki'       => $jumlahLaki,
            'jumlahPerempuan'  => $jumlahPerempuan,
            'persenLaki'       => $persenLaki,
            'persenPerempuan'  => $persenPerempuan,
            'prodiLabels'      => $prodiLabels,
            'prodiData'        => $prodiData,
            'prodiPersen'      => $prodiPersen,
            'kelasLabels'      => $kelasLabels,
            'kelasData'        => $kelasData,
            'kelasPersen'      => $kelasPersen,
            'statusLabels'     => $statusLabels,
            'statusData'       => $statusData,
            'statusPersen'     => $statusPersen,
            'totalDosen'       => $totalDosen,
            'tagihanLabels'    => $tagihanLabels,
            'tagihanData'      => $tagihanData,
            'tagihanPersen'    => $tagihanPersen,
            'totalTagihan'     => $totalTagihan,
        ]);
    }
}