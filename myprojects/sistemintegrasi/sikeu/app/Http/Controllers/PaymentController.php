<?php

namespace App\Http\Controllers;

use App\Models\Tagihan;
use App\Models\Mahasiswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Midtrans\Config;
use Midtrans\Snap;

class PaymentController extends Controller
{
public function tagihan(Request $request)
{
    // 1. Ambil data dari kedua database
    $listTagihan = DB::connection('sikeu')->table('tagihan')->get();
    $mahasiswa = DB::connection('siakad')->table('mahasiswa')->get();

    // 2. Gabungkan data
    foreach ($listTagihan as $item) {
        // Kita cari mahasiswa berdasarkan NIM. 
        // Pastikan kita melakukan trim untuk menghindari spasi tersembunyi
        $mhs = $mahasiswa->first(function ($m) use ($item) {
            return trim((string)$m->nim) === trim((string)$item->nim);
        });
        
        // Simpan ke dalam properti baru
        $item->nama_mahasiswa = $mhs->nama ?? 'Data Tidak Ditemukan';
        $item->nim_mahasiswa = $mhs->nim ?? $item->nim;
    }

    return view('payment', [
        'listTagihan' => $listTagihan,
        'data' => $mahasiswa // Ini untuk modal tambah
    ]);
}
  public function simpan(Request $request)
    {
        $request->validate([
            'student_id' => 'required',
            'amount'     => 'required',
        ]);

        $amount = (int) preg_replace('/[^0-9]/', '', $request->amount);

        try {
            $tagihan = Tagihan::create([
                'nim'                 => $request->student_id,
                'kategori'            => $request->kategori,
                'periode'             => $request->periode ?: null,
                'total_tagihan'       => $amount,
                'tanggal_jatuh_tempo' => $request->tanggal_jatuh_tempo ?: null,
                'status_bayar'        => 'Belum Lunas',
            ]);

            $tagihan->load('mahasiswa');

            Config::$serverKey   = config('midtrans.serverKey');
            Config::$isProduction = config('midtrans.isProduction');
            Config::$isSanitized = true;
            Config::$is3ds       = true;

            $orderId = 'PAY-' . $tagihan->id . '-' . time();

            $params = [
                'transaction_details' => [
                    'order_id'     => $orderId,
                    'gross_amount' => (int) $tagihan->total_tagihan,
                ],
                'customer_details' => [
                    'first_name' => $tagihan->mahasiswa->nama ?? 'Mahasiswa',
                    'email'      => $tagihan->mahasiswa->email ?? 'email@contoh.com',
                ],
                'item_details' => [[
                    'id'       => $tagihan->id,
                    'price'    => (int) $tagihan->total_tagihan,
                    'quantity' => 1,
                    'name'     => 'Tagihan ' . ($tagihan->kategori ?? 'SPP') . ($tagihan->periode ? ' - ' . $tagihan->periode : ''),
                ]],
            ];

            $snapToken = Snap::getSnapToken($params);

            $tagihan->update([
                'order_id'   => $orderId,
                'snap_token' => $snapToken,
            ]);

            return redirect()->back()->with('success', 'Tagihan berhasil dibuat dan terdaftar di Midtrans!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal: ' . $e->getMessage());
        }
    }

    /**
     * Generate ulang Snap Token saat klik tombol Bayar
     */
    public function bayar($id)
    {
        $tagihan = Tagihan::with('mahasiswa')->findOrFail($id);

        if (!$tagihan->mahasiswa) {
            return redirect()->back()->with('error', 'Data mahasiswa tidak ditemukan.');
        }

        Config::$serverKey    = config('midtrans.serverKey');
        Config::$isProduction = config('midtrans.isProduction');
        Config::$isSanitized  = true;
        Config::$is3ds        = true;

        $orderId = 'PAY-' . $tagihan->id . '-' . time();

        $params = [
            'transaction_details' => [
                'order_id'     => $orderId,
                'gross_amount' => (int) $tagihan->total_tagihan,
            ],
            'customer_details' => [
                'first_name' => $tagihan->mahasiswa->nama,
                'email'      => $tagihan->mahasiswa->email ?? 'email@contoh.com',
            ],
            'item_details' => [[
                'id'       => $tagihan->id,
                'price'    => (int) $tagihan->total_tagihan,
                'quantity' => 1,
                'name'     => 'Tagihan ' . ($tagihan->kategori ?? 'SPP') . ($tagihan->periode ? ' - ' . $tagihan->periode : ''),
            ]],
        ];

        try {
            $snapToken = Snap::getSnapToken($params);
            $tagihan->update([
                'order_id'   => $orderId,
                'snap_token' => $snapToken,
            ]);
            return redirect()->back()->with('snapToken', $snapToken);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    /**
     * Webhook callback dari Midtrans
     */
    public function callback(Request $request)
    {
        $serverKey = config('midtrans.serverKey');
        $signature = hash('sha512',
            $request->order_id . $request->status_code . $request->gross_amount . $serverKey
        );

        if ($signature !== $request->signature_key) {
            return response()->json(['message' => 'Invalid Signature'], 403);
        }

        $tagihan = Tagihan::where('order_id', $request->order_id)->first();
        if (!$tagihan) {
            return response()->json(['message' => 'Tagihan not found'], 404);
        }

        $status = $request->transaction_status;
        if ($status == 'settlement' || $status == 'capture') {
            $tagihan->update(['status_bayar' => 'Lunas']);
        } elseif ($status == 'pending') {
            $tagihan->update(['status_bayar' => 'Pending']);
        } elseif (in_array($status, ['deny', 'expire', 'cancel'])) {
            $tagihan->update(['status_bayar' => 'Gagal']);
        }

        return response()->json(['message' => 'Callback Success']);
    }

    /**
     * Cek status pembayaran manual ke Midtrans
     */
    public function cekStatus($id)
    {
        $tagihan = Tagihan::findOrFail($id);
        Config::$serverKey    = config('midtrans.serverKey');
        Config::$isProduction = config('midtrans.isProduction');

        try {
            $status = \Midtrans\Transaction::status($tagihan->order_id);
            if (in_array($status->transaction_status, ['settlement', 'capture'])) {
                $tagihan->update(['status_bayar' => 'Lunas']);
                return redirect()->back()->with('success', 'Pembayaran Terverifikasi!');
            } else {
                return redirect()->back()->with('info', 'Status saat ini: ' . $status->transaction_status);
            }
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    /**
     * Update tagihan
     */
    public function update(Request $request, $id)
    {
        $tagihan = Tagihan::findOrFail($id);
        $amount  = (int) preg_replace('/[^0-9]/', '', $request->amount);

        $tagihan->update([
            'kategori'            => $request->kategori,
            'periode'             => $request->kategori === 'SPP' ? $request->periode : null,
            'total_tagihan'       => $amount,
            'tanggal_jatuh_tempo' => $request->tanggal_jatuh_tempo ?: null,
        ]);

        return redirect()->back()->with('success', 'Tagihan berhasil diperbarui!');
    }

    /**
     * Hapus tagihan
     */
    public function hapus($id)
    {
        Tagihan::findOrFail($id)->delete();
        return redirect()->back()->with('success', 'Tagihan berhasil dihapus!');
    }

    /**
     * Dashboard analisis keuangan SIKEU
     */
    public function dashboard(Request $request)
    {
        $tahun = $request->input('tahun', date('Y'));
        $bulan = $request->input('bulan');

        // 1. Total revenue (Lunas)
        $queryRevenue = DB::connection('sikeu')->table('tagihan')
            ->where('status_bayar', 'Lunas')
            ->whereYear('tanggal_jatuh_tempo', $tahun);
        if ($bulan && $bulan !== 'Semua Bulan') {
            $queryRevenue->whereMonth('tanggal_jatuh_tempo', $bulan);
        }
        $totalRevenue = $queryRevenue->sum('total_tagihan');

        // 2. Outstanding receivables (Belum Lunas + Pending)
        $queryReceivables = DB::connection('sikeu')->table('tagihan')
            ->whereIn('status_bayar', ['Belum Lunas', 'Pending'])
            ->whereYear('tanggal_jatuh_tempo', $tahun);
        if ($bulan && $bulan !== 'Semua Bulan') {
            $queryReceivables->whereMonth('tanggal_jatuh_tempo', $bulan);
        }
        $outstandingReceivables = $queryReceivables->sum('total_tagihan');

        // 3. Overdue bills — build query dulu, get() setelah semua filter
        $queryOverdue = DB::connection('sikeu')->table('tagihan')
            ->where('status_bayar', 'Belum Lunas')
            ->where('tanggal_jatuh_tempo', '<', now())
            ->whereYear('tanggal_jatuh_tempo', $tahun);
        if ($bulan && $bulan !== 'Semua Bulan') {
            $queryOverdue->whereMonth('tanggal_jatuh_tempo', $bulan);
        }
        $overdueList  = $queryOverdue->get();
        $overdueBills = $overdueList->sum('total_tagihan');

        // Enrichment: tempelkan data mahasiswa ke tiap baris overdue
        // Gunakan koneksi 'siakad' (bukan 'mysql') agar tidak nyasar ke database default
        $semuaMahasiswa = DB::connection('siakad')->table('mahasiswa')->get();
        foreach ($overdueList as $item) {
            $nimTagihan = trim((string) $item->nim);
            $mhsCocok   = $semuaMahasiswa->first(fn($m) => trim((string)$m->nim) === $nimTagihan);
            $item->mahasiswa = (object) [
                'nama'  => $mhsCocok->nama  ?? 'Tidak Ditemukan',
                'nim'   => $mhsCocok->nim   ?? $item->nim,
                'no_hp' => $mhsCocok->no_hp ?? null,
                'email' => $mhsCocok->email ?? null,
            ];
        }

        // 4. Collection rate
        $totalTagihanCombined = $totalRevenue + $outstandingReceivables;
        $collectionRate = $totalTagihanCombined > 0
            ? ($totalRevenue / $totalTagihanCombined) * 100
            : 0;

        // 5. Data grafik bulanan (12 bulan)
        $dataLunasBulanan      = [];
        $dataBelumLunasBulanan = [];
        $dataOverdueBulanan    = [];

        for ($m = 1; $m <= 12; $m++) {
            if ($bulan && $bulan !== 'Semua Bulan' && $bulan != $m) {
                $dataLunasBulanan[]      = 0;
                $dataBelumLunasBulanan[] = 0;
                $dataOverdueBulanan[]    = 0;
                continue;
            }

            $dataLunasBulanan[] = DB::connection('sikeu')->table('tagihan')
                ->where('status_bayar', 'Lunas')
                ->whereYear('tanggal_jatuh_tempo', $tahun)
                ->whereMonth('tanggal_jatuh_tempo', $m)
                ->sum('total_tagihan');

            $dataBelumLunasBulanan[] = DB::connection('sikeu')->table('tagihan')
                ->whereIn('status_bayar', ['Belum Lunas', 'Pending'])
                ->whereYear('tanggal_jatuh_tempo', $tahun)
                ->whereMonth('tanggal_jatuh_tempo', $m)
                ->sum('total_tagihan');

            $dataOverdueBulanan[] = DB::connection('sikeu')->table('tagihan')
                ->where('status_bayar', 'Belum Lunas')
                ->where('tanggal_jatuh_tempo', '<', now())
                ->whereYear('tanggal_jatuh_tempo', $tahun)
                ->whereMonth('tanggal_jatuh_tempo', $m)
                ->sum('total_tagihan');
        }

        // 6. Donut chart per kategori (Lunas)
        $queryDonut = DB::connection('sikeu')->table('tagihan')
            ->select('kategori', DB::raw('SUM(total_tagihan) as total'))
            ->where('status_bayar', 'Lunas')
            ->whereYear('tanggal_jatuh_tempo', $tahun);
        if ($bulan && $bulan !== 'Semua Bulan') {
            $queryDonut->whereMonth('tanggal_jatuh_tempo', $bulan);
        }
        $donutDataRaw = $queryDonut->groupBy('kategori')->orderBy('kategori')->get();
        $donutLabels  = $donutDataRaw->pluck('kategori')->toArray();
        $donutValues  = $donutDataRaw->pluck('total')->map(fn($v) => (int)$v)->toArray();

        return view('dashboard', compact(
            'totalRevenue',
            'outstandingReceivables',
            'overdueBills',
            'overdueList',
            'collectionRate',
            'tahun',
            'bulan',
            'dataLunasBulanan',
            'dataBelumLunasBulanan',
            'dataOverdueBulanan',
            'donutLabels',
            'donutValues'
        ));
    }
}