@extends('adminlte::page')

@section('title', 'Dashboard SIAKAD')

@push('css')
<style>
/* ============================================================ 
   NABILA'S CUSTOM ADMINLTE GLOBAL THEME
   ============================================================ */

/* 1. WARNA UTAMA SIDEBAR & BACKGROUND GLOBAL */
.main-sidebar, .sidebar { 
    background-color: #377EC0 !important; 
}
.content-wrapper { 
    background: #edf1f7 !important; 
}

/* 2. MENYEMBUNYIKAN BRAND TEXT BAWAAN (KARENA DIGANTI PROFIL BULAT) */
.main-sidebar .brand-link { 
    display: none !important; 
}

/* 3. PROFIL LINGKARAN ADMIN (STRUKTUR DI ALL PAGES) */
.sidebar-profile-box {
    padding: 20px 15px 15px 15px;
    text-align: center;
    border-bottom: 1px solid rgba(255, 255, 255, 0.15);
    margin-bottom: 15px;
}
.sidebar-avatar {
    width: 65px; height: 65px;
    border-radius: 50%; 
    background: rgba(255,255,255,0.2);
    border: 2.5px solid rgba(255,255,255,0.6);
    display: flex; align-items: center; justify-content: center;
    margin: 0 auto 10px auto;
    box-shadow: 0 4px 8px rgba(0,0,0,0.1);
}
.sidebar-avatar i { font-size: 1.6rem; color: #fff; }
.sidebar-name { color:#fff; font-weight:700; font-size:0.95rem; display:block; line-height:1.2; }
.sidebar-role { color:rgba(255,255,255,0.75); font-size:0.72rem; display:block; margin-top:3px; }

/* 4. NAVIGASI MENU UTAMA (BIAR GA MENABRAK DINDING SIDEBAR) */
.sidebar .nav-sidebar .nav-item .nav-link {
    color: rgba(255,255,255,0.9) !important; 
    border-radius: 8px !important;
    margin: 4px 14px !important; 
    padding: 10px 14px !important; 
    font-size: 0.85rem; 
    transition: all 0.2s ease;
    width: calc(100% - 28px) !important;
}
/* Efek Hover & Active Seimbang */
.sidebar .nav-sidebar .nav-item .nav-link:hover,
.sidebar .nav-sidebar .nav-item .nav-link.active { 
    background: rgba(255,255,255,0.18) !important; 
    color: #fff !important; 
}
.sidebar .nav-sidebar .nav-item .nav-link.active { 
    box-shadow: 0 2px 6px rgba(0,0,0,0.08); 
}
.sidebar .nav-sidebar .nav-item .nav-link .nav-icon { 
    color: rgba(255,255,255,0.7) !important; 
}
.sidebar .nav-sidebar .nav-item .nav-link.active .nav-icon { 
    color: #FBDF54 !important; 
}
.sidebar .nav-header { 
    color: rgba(255,255,255,0.5) !important; 
    font-size: 0.68rem !important; 
    letter-spacing: 1.2px !important; 
    padding: 12px 24px 4px !important; 
}

/* 5. SEARCH BOX SIDEBAR UTAMA */
.sidebar-search-block { 
    padding: 0 14px; 
    margin-bottom: 15px; 
}
.sidebar .form-control-sidebar { 
    background: rgba(0,0,0,0.1) !important; 
    border: 1px solid rgba(255,255,255,0.15) !important; 
    color: #fff !important; 
    border-radius: 8px 0 0 8px !important; 
    height: 35px; 
}
.sidebar .form-control-sidebar::placeholder { 
    color: rgba(255,255,255,0.55) !important; 
}
.sidebar .btn-sidebar { 
    background: rgba(0,0,0,0.1) !important; 
    border: 1px solid rgba(255,255,255,0.15) !important; 
    border-left: none !important; 
    color: rgba(255,255,255,0.6) !important; 
    border-radius: 0 8px 8px 0 !important; 
    height: 35px; 
}

/* 6. TOPBAR FIX WHITE & CLEAN */
.main-header.navbar { 
    background: #fff !important; 
    border-bottom: 1px solid #dce6f0 !important; 
    box-shadow: 0 2px 6px rgba(55,126,192,0.05); 
    height: 57px; 
}

/* 7. TRICK CSS DATATABLES: MEMAKSA SEARCH BERPINDAH KE KANAN SHOW ENTRIES */
.dataTables_wrapper .row:first-child {
    display: flex !important;
    align-items: center !important;
    justify-content: flex-start !important;
    gap: 15px !important;
    margin-bottom: 15px !important;
}
.dataTables_wrapper .row:first-child > div {
    flex: unset !important;
    max-width: unset !important;
}
.dataTables_wrapper .dataTables_length { 
    margin-right: 0 !important; 
}
.dataTables_wrapper .dataTables_filter { 
    margin-left: 0 !important; 
    text-align: left !important; 
}
.dataTables_wrapper .dataTables_filter label { 
    margin-bottom: 0 !important; 
    display: flex !important; 
    align-items: center !important; 
    gap: 5px; 
}
/* ============================================================ TOPBAR, WIDGET, & LAYOUT */
.main-header.navbar { background:#fff !important; border-bottom:1px solid #dce6f0 !important; box-shadow:0 2px 6px rgba(55,126,192,0.05); height: 57px; }
.content-wrapper { background:#edf1f7 !important; }
.content { padding: 16px !important; }

/* Widget Live Info (Weather & Date) di Topbar */
.topbar-widgets {
    display: flex; align-items: center; gap: 18px; color: #4a5568; font-size: 0.85rem; font-weight: 500; padding-right: 15px;
}
.widget-item { display: flex; align-items: center; gap: 7px; background: #f7fafc; padding: 5px 12px; border-radius: 30px; border: 1px solid #e2e8f0; }
.widget-item i { color: #377EC0; font-size: 0.9rem; }

/* Dashboard Wrapper Grid */
.dashboard-wrap { display: flex; flex-direction: column; gap: 16px; width: 100%; max-width: 100%; margin: 0 auto; }
.row-kpi, .row-donut, .row-bar { width: 100%; }

/* Container Card Layout */
.chart-card {
    background:#fff; border-radius:12px; box-shadow: 0 4px 12px rgba(0,0,0,.04); border:1px solid #e2e8f0;
    display:flex; flex-direction:column; overflow:hidden; height: 100%; margin-bottom: 0;
}
.chart-card-header { padding:14px 18px; border-bottom:1px solid #eef2f7; display:flex; align-items:center; justify-content: space-between; }
.chart-card-header .left-side { display: flex; align-items: center; gap: 8px; }
.chart-card-header .hd { width:9px; height:9px; border-radius:50%; flex-shrink:0; }
.chart-card-header h6 { font-size:0.8rem; font-weight:700; color:#2d3748; margin:0; text-transform:uppercase; letter-spacing:0.5px; }

/* Donut & Bar Configurations */
.donut-card { min-height: 220px; }
.donut-wrap { flex:1; display:flex; align-items:center; padding:15px 20px; gap:20px; }
.donut-legend { flex:1; display:flex; flex-direction:column; gap:8px; }
.leg-row { display:flex; align-items:center; gap:8px; }
.leg-dot { width:10px; height:10px; border-radius:3px; flex-shrink:0; }
.leg-label{ font-size:0.78rem; color:#4a5568; flex:1; font-weight:500; }
.leg-num { font-size:0.82rem; font-weight:700; color:#1e2d3d; }
.leg-pct { font-size:0.75rem; color:#9aa5b4; min-width:35px; text-align:right; }

.bar-legend { display:flex; gap:14px; font-size:0.75rem; font-weight:500; color:#4a5568; }
.bar-leg-item { display:flex; align-items:center; gap:6px; }
.bar-leg-dot { width:11px; height:11px; border-radius:3px; }
.bar-body { flex:1; padding:20px; position:relative; min-height: 280px; }

/* ============================================================ KPI CARDS */
.kpi-card {
    border-radius:12px; padding:18px; display:flex; align-items:center; gap:15px;
    box-shadow:0 4px 10px rgba(0,0,0,0.04); border:none; min-height:85px; position:relative; overflow:hidden;
}
.kpi-icon { width:48px; height:48px; border-radius:10px; background:rgba(255,255,255,0.22); display:flex; align-items:center; justify-content:center; font-size:1.3rem; color:#fff; flex-shrink:0; }
.kpi-val { font-size:1.7rem; font-weight:800; color:#fff; line-height:1; }
.kpi-lbl { font-size:0.72rem; color:rgba(255,255,255,0.85); font-weight:600; text-transform:uppercase; letter-spacing:0.5px; margin-top:4px; }
.kpi-mhs { background: linear-gradient(135deg, #3b82f6, #1d4ed8); }
.kpi-mk { background: linear-gradient(135deg, #6366f1, #4338ca); }
.kpi-dosen { background: linear-gradient(135deg, #10b981, #047857); }
.kpi-tagihan { background: linear-gradient(135deg, #f97316, #c2410c); }
</style>
@endpush

{{-- Menyisipkan Widget Info Cuaca & Tanggal Ke Topbar --}}
@section('content_top_nav_right')
<div class="topbar-widgets">
    <div class="widget-item">
        <i class="far fa-calendar-alt"></i>
        <span id="live-date">Memuat Tanggal...</span>
    </div>
    <div class="widget-item">
        <i class="fas fa-cloud-sun" id="weather-icon"></i>
        <span id="live-weather">Surakarta: --°C</span>
    </div>
</div>
@endsection

@section('content_header')
    <div class="d-flex align-items-center justify-content-between mt-2 mb-1">
        <h1 class="m-0" style="font-size:1.3rem !important; font-weight:700 !important; color:#1e2d3d;"><i class="fas fa-tachometer-alt mr-2" style="color:#377EC0"></i>Dashboard Sistem Informasi Akademik</h1>
    </div>
@endsection

@section('content')
@php
    $palette       = ['#377EC0','#12BAAA','#FBDF54','#F04F52','#5460AC','#F7891F'];
    $tagihanColors = ['#F04F52','#12BAAA','#FBDF54','#9FD2D6'];

    // Pemrosesan Data Angkatan Terstruktur
    $angkatanMap = [];
    foreach(($kelasLabels ?? []) as $idx => $kelas) {
        preg_match('/(\d{2})/', $kelas, $m);
        $thn = isset($m[1]) ? '20'.$m[1] : '2024';
        if (!isset($angkatanMap[$thn])) $angkatanMap[$thn] = 0;
        $angkatanMap[$thn] += $kelasData[$idx] ?? 0;
    }
    ksort($angkatanMap);
    $angkatanLabels = array_keys($angkatanMap);
    $angkatanData   = array_values($angkatanMap);

    // Rasio Gender Estimasi
    $ratio = ($totalMahasiswa > 0) ? ($jumlahLaki / $totalMahasiswa) : 0.55;
    $prodiLakiData = array_map(fn($v) => round($v * $ratio), $prodiData);
    $prodiPrpData  = array_map(fn($v,$l) => $v - $l, $prodiData, $prodiLakiData);
    $angkLakiData  = array_map(fn($v) => round($v * $ratio), $angkatanData);
    $angkPrpData   = array_map(fn($v,$l) => $v - $l, $angkatanData, $angkLakiData);
@endphp

<div class="dashboard-wrap">
    {{-- KPI GRID ROW --}}
    <div class="row-kpi">
        <div class="row">
            <div class="col-6 col-lg-3 mb-3 mb-lg-0">
                <div class="kpi-card kpi-mhs">
                    <div class="kpi-icon"><i class="fas fa-user-graduate"></i></div>
                    <div>
                        <div class="kpi-val">{{ number_format($totalMahasiswa) }}</div>
                        <div class="kpi-lbl">Total Mahasiswa</div>
                    </div>
                </div>
            </div>
            <div class="col-6 col-lg-3 mb-3 mb-lg-0">
                <div class="kpi-card kpi-mk">
                    <div class="kpi-icon"><i class="fas fa-book-open"></i></div>
                    <div>
                        <div class="kpi-val">{{ number_format($totalMataKuliah ?? 10) }}</div>
                        <div class="kpi-lbl">Total Mata Kuliah</div>
                    </div>
                </div>
            </div>
            <div class="col-6 col-lg-3 mb-3 mb-lg-0">
                <div class="kpi-card kpi-dosen">
                    <div class="kpi-icon"><i class="fas fa-chalkboard-teacher"></i></div>
                    <div>
                        <div class="kpi-val">{{ number_format($totalDosen) }}</div>
                        <div class="kpi-lbl">Total Dosen</div>
                    </div>
                </div>
            </div>
            <div class="col-6 col-lg-3 mb-3 mb-lg-0">
                <div class="kpi-card kpi-tagihan">
                    <div class="kpi-icon"><i class="fas fa-file-invoice-dollar"></i></div>
                    <div>
                        <div class="kpi-val">{{ number_format($totalTagihan) }}</div>
                        <div class="kpi-lbl">Total Tagihan</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- DONUT CHARTS ROW --}}
    <div class="row-donut">
        <div class="row">
            <div class="col-md-4 mb-3 mb-md-0">
                <div class="chart-card donut-card">
                    <div class="chart-card-header">
                        <div class="left-side"><span class="hd" style="background:#377EC0"></span><h6>Rasio Gender</h6></div>
                    </div>
                    <div class="donut-wrap">
                        <canvas id="chartGender" width="105" height="105"></canvas>
                        <div class="donut-legend">
                            <div class="leg-row"><span class="leg-dot" style="background:#377EC0"></span><span class="leg-label">Laki-laki</span><span class="leg-num">{{ $jumlahLaki }}</span><span class="leg-pct">{{ $persenLaki }}%</span></div>
                            <div class="leg-row"><span class="leg-dot" style="background:#F04F52"></span><span class="leg-label">Perempuan</span><span class="leg-num">{{ $jumlahPerempuan }}</span><span class="leg-pct">{{ $persenPerempuan }}%</span></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-3 mb-md-0">
                <div class="chart-card donut-card">
                    <div class="chart-card-header">
                        <div class="left-side"><span class="hd" style="background:#12BAAA"></span><h6>Status Mahasiswa</h6></div>
                    </div>
                    <div class="donut-wrap">
                        <canvas id="chartStatus" width="105" height="105"></canvas>
                        <div class="donut-legend">
                            @foreach($statusLabels as $i => $label)
                            <div class="leg-row">
                                <span class="leg-dot" style="background:{{ $palette[$i % count($palette)] }}"></span>
                                <span class="leg-label">{{ $label }}</span>
                                <span class="leg-num">{{ $statusData[$i] }}</span>
                                <span class="leg-pct">{{ $statusPersen[$i] }}%</span>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="chart-card donut-card">
                    <div class="chart-card-header">
                        <div class="left-side"><span class="hd" style="background:#F7891F"></span><h6>Status Tagihan</h6></div>
                    </div>
                    <div class="donut-wrap">
                        <canvas id="chartTagihan" width="105" height="105"></canvas>
                        <div class="donut-legend">
                            @foreach($tagihanLabels as $i => $label)
                            <div class="leg-row">
                                <span class="leg-dot" style="background:{{ $tagihanColors[$i % count($tagihanColors)] }}"></span>
                                <span class="leg-label">{{ $label }}</span>
                                <span class="leg-num">{{ $tagihanData[$i] }}</span>
                                <span class="leg-pct">{{ $tagihanPersen[$i] }}%</span>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- STACKED BAR CHARTS ROW (Perubahan Utama) --}}
    <div class="row-bar">
        <div class="row">
            <div class="col-md-6 mb-3 mb-md-0">
                <div class="chart-card">
                    <div class="chart-card-header">
                        <div class="left-side"><span class="hd" style="background:#377EC0"></span><h6>Mahasiswa per Program Studi</h6></div>
                        <div class="bar-legend">
                            <div class="bar-leg-item"><span class="bar-leg-dot" style="background:#377EC0"></span>Laki-laki</div>
                            <div class="bar-leg-item"><span class="bar-leg-dot" style="background:#F04F52"></span>Perempuan</div>
                        </div>
                    </div>
                    <div class="bar-body">
                        <canvas id="chartProdi"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="chart-card">
                    <div class="chart-card-header">
                        <div class="left-side"><span class="hd" style="background:#12BAAA"></span><h6>Mahasiswa per Tahun Angkatan</h6></div>
                        <div class="bar-legend">
                            <div class="bar-leg-item"><span class="bar-leg-dot" style="background:#12BAAA"></span>Laki-laki</div>
                            <div class="bar-leg-item"><span class="bar-leg-dot" style="background:#F7891F"></span>Perempuan</div>
                        </div>
                    </div>
                    <div class="bar-body">
                        <canvas id="chartAngkatan"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

{{-- Modifikasi Sidebar Utama --}}
@section('sidebar_brand')
<div class="sidebar-profile-box">
    <div class="sidebar-avatar">
        <i class="fas fa-user-shield"></i>
    </div>
    <span class="sidebar-name">Nabila Hulwana</span>
    <span class="sidebar-role">Administrator SIAKAD</span>
</div>
@endsection

@section('js')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script>
$(document).ready(function () {

    // 1. LIVE TIME & DATE WIDGET (TANPA API LUAR)
    function updateDateTime() {
        const sekarang = new Date();
        const opsi = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
        $('#live-date').text(sekarang.toLocaleDateString('id-ID', opsi));
    }
    updateDateTime();

    // 2. LIVE WEATHER INTEGRASI API (OPENWEATHERMAP)
    const apiKey = 'a40ef2dfcac48e883287ffc3c60b9b2c'; // <-- Ganti dengan API Key milikmu
    const kota = 'Surakarta';
    
    if(apiKey !== 'PILIH_API_KEY_MU_DISINI') {
        const weatherUrl = `https://api.openweathermap.org/data/2.5/weather?q=${kota}&appid=${apiKey}&units=metric&lang=id`;
        
        // Asynchronous Request ke OpenWeather API
        $.getJSON(weatherUrl, function(data) {
            const suhu = Math.round(data.main.temp);
            const deskripsi = data.weather[0].description;
            const kodeIkon = data.weather[0].icon;
            
            $('#live-weather').text(`${kota}: ${suhu}°C, ${deskripsi}`);
            // Mengubah icon dinamis sesuai cuaca real-time
            $('#weather-icon').attr('class', `fas fa-cloud`);
        }).fail(function() {
            $('#live-weather').text('Surakarta: 29°C, Cerah Berawan'); // Fallback data dummy jika gagal load/limit
        });
    } else {
        // Fallback default jika user belum memasukkan API Key
        $('#live-weather').text('Surakarta: 28°C, Berawan');
    }

    // 3. GENERATE DONUT CHARTS
   // 3. GENERATE DONUT CHARTS (Dipertebal dengan cutout 50%)
    function makeDonut(id, data, colors) {
        new Chart(document.getElementById(id), {
            type: 'doughnut',
            data: { datasets: [{ data, backgroundColor: colors, borderWidth: 2, borderColor: '#fff' }] },
            options: { responsive: false, cutout: '50%', plugins: { legend: { display: false } } }
        });
    }
    makeDonut('chartGender',  [{{ $jumlahLaki }}, {{ $jumlahPerempuan }}], ['#377EC0','#F04F52']);
    makeDonut('chartStatus',  @json($statusData),  ['#377EC0','#12BAAA','#FBDF54','#F04F52']);
    makeDonut('chartTagihan', @json($tagihanData), ['#F04F52','#12BAAA','#FBDF54','#9FD2D6']);

// 4. CUSTOM IN-BAR LABELS & TOTAL ABOVE TOP PLUGIN (ATAS-BAWAH MODE)
    const stackedLabelPlugin = {
        id: 'stackedLabelPlugin',
        afterDatasetsDraw(chart) {
            const { ctx, data } = chart;
            const metaLaki = chart.getDatasetMeta(0).data;
            const metaPrp  = chart.getDatasetMeta(1).data;
            const totalMhs = {{ $totalMahasiswa }};

            metaLaki.forEach((barLaki, i) => {
                const barPrp = metaPrp[i];
                const valLaki = data.datasets[0].data[i] || 0;
                const valPrp  = data.datasets[1].data[i] || 0;
                const totalKat = valLaki + valPrp;

                // Hitung Persentase Gender Internal Kategori
                const pctLaki = totalKat > 0 ? ((valLaki / totalKat) * 100).toFixed(0) + '%' : '0%';
                const pctPrp  = totalKat > 0 ? ((valPrp / totalKat) * 100).toFixed(0) + '%' : '0%';
                
                // Hitung Persentase Kontribusi Konten Terhadap Total Universitas
                const pctKontribusi = totalMhs > 0 ? `(${((totalKat / totalMhs) * 100).toFixed(1)}%)` : '(0%)';

                ctx.save();
                ctx.textAlign = 'center';
                ctx.textBaseline = 'middle';
                ctx.font = '600 10px Inter, sans-serif';

                // === A. TEKS DI DALAM BAR GRAPH (ATAS-BAWAH) ===
                
                // Teks Bar Laki-laki (Biru / Teal)
                if (valLaki > 2) {
                    const yCenterLaki = (barLaki.y + barLaki.base) / 2;
                    // Angka Total di atas (Hitam)
                    ctx.fillStyle = '#000000';
                    ctx.fillText(valLaki, barLaki.x, yCenterLaki - 6);
                    // Angka Persen di bawah (Putih)
                    ctx.fillStyle = '#ffffff';
                    ctx.fillText(pctLaki, barLaki.x, yCenterLaki + 6);
                }

                // Teks Bar Perempuan (Merah / Oranye)
                if (valPrp > 2) {
                    const yCenterPrp = (barPrp.y + barPrp.base) / 2;
                    // Angka Total di atas (Hitam)
                    ctx.fillStyle = '#000000';
                    ctx.fillText(valPrp, barPrp.x, yCenterPrp - 6);
                    // Angka Persen di bawah (Putih)
                    ctx.fillStyle = '#ffffff';
                    ctx.fillText(pctPrp, barPrp.x, yCenterPrp + 6);
                }

                // === B. TEKS DI ATAS BAR GRAPH ===
                ctx.font = 'bold 11px Inter, sans-serif';
                const xText = barPrp.x;
                const yText = barPrp.y - 12;

                const totalTextWidth = ctx.measureText(totalKat + ' ').width;

                // Menggambar Angka Total di Atas Chart (Hitam)
                ctx.textAlign = 'right';
                ctx.fillStyle = '#000000';
                ctx.fillText(totalKat, xText + (totalTextWidth / 4), yText);

                // Menggambar Angka Persen Kontribusi di Atas Chart (Abu-Abu)
                ctx.textAlign = 'left';
                ctx.fillStyle = '#718096'; 
                ctx.fillText(pctKontribusi, xText + (totalTextWidth / 4) + 2, yText);

                ctx.restore();
            });
        }
    };

// Opsi konfigurasi dasar agar lebar grafik lumayan besar dan sama rata
    const commonOptions = {
        responsive: true, 
        maintainAspectRatio: false,
        plugins: { legend: { display: false } },
        scales: {
            x: { 
                stacked: true, 
                grid: { display: false } 
            },
            y: { 
                stacked: true, 
                beginAtZero: true, 
                grid: { color: '#f0f4f8' }, 
                ticks: { stepSize: 5 } 
            }
        }
    };

    // 5. RENDER STACKED BAR CHART - PRODI (Gradasi Cerah)
    (function() {
        const canvas = document.getElementById('chartProdi');
        const ctx = canvas.getContext('2d');

        // Gradasi Biru Cerah (Laki-laki)
        const gradLaki = ctx.createLinearGradient(0, 0, 0, 250);
        gradLaki.addColorStop(0, '#4da3f7'); // Lebih terang di atas
        gradLaki.addColorStop(1, '#377EC0'); // Warna asli donut di bawah

        // Gradasi Merah Cerah (Perempuan)
        const gradPrp = ctx.createLinearGradient(0, 0, 0, 150);
        gradPrp.addColorStop(0, '#ff6b6e'); // Lebih terang di atas
        gradPrp.addColorStop(1, '#F04F52'); // Warna asli donut di bawah

        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: @json($prodiLabels),
                datasets: [
                    { 
                        label: 'Laki-laki', 
                        data: @json($prodiLakiData), 
                        backgroundColor: gradLaki, 
                        barPercentage: 0.65, 
                        categoryPercentage: 0.75,
                        borderRadius: { topLeft: 0, topRight: 0, bottomLeft: 8, bottomRight: 8 }, 
                        borderSkipped: false 
                    },
                    { 
                        label: 'Perempuan', 
                        data: @json($prodiPrpData), 
                        backgroundColor: gradPrp, 
                        barPercentage: 0.65, 
                        categoryPercentage: 0.75,
                        borderRadius: { topLeft: 8, topRight: 8, bottomLeft: 0, bottomRight: 0 }, 
                        borderSkipped: false
                    }
                ]
            },
            options: commonOptions,
            plugins: [stackedLabelPlugin]
        });
    })();

    // 6. RENDER STACKED BAR CHART - ANGKATAN (Gradasi Cerah)
    (function() {
        const canvas = document.getElementById('chartAngkatan');
        const ctx = canvas.getContext('2d');

        // Gradasi Teal Cerah (Laki-laki)
        const gradLakiAngk = ctx.createLinearGradient(0, 0, 0, 250);
        gradLakiAngk.addColorStop(0, '#26e6d3'); // Lebih terang di atas
        gradLakiAngk.addColorStop(1, '#12BAAA'); // Warna asli donut di bawah

        // Gradasi Oranye Cerah (Perempuan)
        const gradPrpAngk = ctx.createLinearGradient(0, 0, 0, 150);
        gradPrpAngk.addColorStop(0, '#ffa852'); // Lebih terang di atas
        gradPrpAngk.addColorStop(1, '#F7891F'); // Warna asli donut di bawah

        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: @json($angkatanLabels),
                datasets: [
                    { 
                        label: 'Laki-laki', 
                        data: @json($angkLakiData), 
                        backgroundColor: gradLakiAngk, 
                        barPercentage: 0.65, 
                        categoryPercentage: 0.75,
                        borderRadius: { topLeft: 0, topRight: 0, bottomLeft: 8, bottomRight: 8 },
                        borderSkipped: false
                    },
                    { 
                        label: 'Perempuan', 
                        data: @json($angkPrpData), 
                        backgroundColor: gradPrpAngk, 
                        barPercentage: 0.65, 
                        categoryPercentage: 0.75,
                        borderRadius: { topLeft: 8, topRight: 8, bottomLeft: 0, bottomRight: 0 },
                        borderSkipped: false
                    }
                ]
            },
            options: commonOptions,
            plugins: [stackedLabelPlugin]
        });
    })();
});
</script>
@endsection