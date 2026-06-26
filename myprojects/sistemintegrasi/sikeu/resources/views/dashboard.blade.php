@extends('adminlte::page')

@section('title', 'Dashboard Keuangan')

@section('sidebar_brand')
<div class="sidebar-profile-box">
    <div class="sidebar-avatar"><i class="fas fa-wallet"></i></div>
    <span class="sidebar-name">Nabila Hulwana</span>
    <span class="sidebar-role">Administrator SIKEU</span>
</div>
@endsection

@push('css')
<style>
.main-sidebar, .sidebar { background: linear-gradient(135deg, #377EC0 0%, #205081 100%) !important; }
.content-wrapper { background: #edf1f7 !important; }
.main-sidebar .brand-link { display: none !important; }
.card-chart { border-radius: 12px !important; box-shadow: 0 4px 15px rgba(0,0,0,0.02) !important; border: none !important; margin-bottom: 20px; }
.card-chart .card-header { background: #fff !important; border-bottom: 1px solid #edf2f9 !important; padding: 16px 20px !important; }

/* Styling Ringkasan Header Chart */
.income-overview-header { display: flex; justify-content: space-around; text-align: center; border-bottom: 1px solid #edf2f9; padding-bottom: 15px; margin-bottom: 15px; }
.overview-item p { margin: 0; font-size: 0.8rem; color: #7f8c8d; font-weight: 500; }
.overview-item h4 { margin: 3px 0 0 0; font-size: 1.3rem; font-weight: 700; }

.scrollable-table-wrapper { max-height: 270px; overflow-y: auto; overflow-x: hidden; }
.filter-select { background-color: #fff; border: 1px solid #ced4da; border-radius: 8px; padding: 6px 12px; font-size: 0.85rem; font-weight: 600; height: auto; display: inline-block; width: auto; }
.filter-select:focus { border-color: #377EC0; outline: 0; box-shadow: 0 0 0 0.2rem rgba(55,126,192,0.25); }

/* Button Clear Filter Style */
.btn-clear-filter { border-radius: 8px; font-size: 0.85rem; font-weight: 600; padding: 6px 12px; background-color: #f8f9fa; border: 1px solid #ced4da; color: #6c757d; transition: all 0.2s; }
.btn-clear-filter:hover { background-color: #e2e6ea; color: #343a40; text-decoration: none; }
</style>
@endpush

@section('content_header')
<div class="d-flex flex-column flex-sm-row justify-content-between align-items-start align-items-sm-center pb-2">
    <h1 style="color:#2c3e50;font-weight:700;" class="mb-2 mb-sm-0">Dashboard Analisis Keuangan (SIKEU)</h1>
    <form action="{{ route('dashboard') }}" method="GET" id="filterForm">
        <div class="d-flex align-items-center">
            <span class="mr-2 text-secondary font-weight-bold" style="font-size:0.85rem;">
                <i class="fas fa-filter text-primary mr-1"></i> Filter Data:
            </span>
            <select class="form-control filter-select mr-2" name="tahun" onchange="this.form.submit()">
                <option value="2026" {{ $tahun == '2026' ? 'selected' : '' }}>Tahun 2026</option>
                <option value="2025" {{ $tahun == '2025' ? 'selected' : '' }}>Tahun 2025</option>
            </select>
            <select class="form-control filter-select mr-2" name="bulan" onchange="this.form.submit()">
                <option value="Semua Bulan" {{ $bulan == 'Semua Bulan' || !$bulan ? 'selected' : '' }}>Semua Bulan</option>
                @for ($i = 1; $i <= 12; $i++) 
                    <option value="{{ $i }}" {{ $bulan == $i ? 'selected' : '' }}>{{ date('F', mktime(0,0,0,$i,1)) }}</option> 
                @endfor
            </select>
            
            {{-- TOMBOL CLEAR FILTER (DIKEMBALIKAN) --}}
            <a href="{{ route('dashboard') }}" class="btn btn-clear-filter">
                <i class="fas fa-undo-alt mr-1"></i> Clear Filter
            </a>
        </div>
    </form>
</div>
@endsection

@section('content')

{{-- BARIS 1: MIXED CHART (POSISI PALING ATAS, TANPA KPI) --}}
<div class="row">
    <div class="col-12">
        <div class="card card-chart">
            <div class="card-header"><h3 class="card-title"><i class="fas fa-chart-bar mr-2 text-primary"></i> Income Overview & Billings Trend Analysis</h3></div>
            <div class="card-body">
                <div class="income-overview-header">
                    <div class="overview-item"><p>Paid Invoices</p><h4 style="color:#12BAAA;" id="summary-paid">Rp 0</h4></div>
                    <div class="overview-item"><p>Overdue Invoices</p><h4 style="color:#F04F52;" id="summary-overdue">Rp 0</h4></div>
                    <div class="overview-item"><p>Open Invoices</p><h4 style="color:#F7B924;" id="summary-open">Rp 0</h4></div>
                    {{-- COLLECTION RATE BERWARNA HITAM --}}
                    <div class="overview-item"><p>Collection Rate</p><h4 style="color:#000000; font-weight: 700;" id="summary-rate">{{ number_format($collectionRate, 1, ',', '.') }}%</h4></div>
                </div>
                <div class="chart"><canvas id="mixedOverviewChart" style="min-height:300px;height:300px;max-height:300px;max-width:100%;"></canvas></div>
            </div>
        </div>
    </div>
</div>

{{-- BARIS 2: DONUT + TABEL OVERDUE (LANGSUNG TERLIHAT TANPA SCROLL) --}}
<div class="row">
    <div class="col-md-5">
        <div class="card card-chart">
            <div class="card-header"><h3 class="card-title"><i class="fas fa-chart-pie mr-2 text-primary"></i> Komposisi Kas per Kategori</h3></div>
            <div class="card-body">
                <div class="d-flex align-items-center justify-content-between" style="height:270px; gap:15px;">
                    <div style="width:35%;height:100%;position:relative;"><canvas id="donutChartKategori"></canvas></div>
                    <div id="custom-donut-legend" style="width:65%;max-height:250px;overflow-y:auto;padding-right:5px;"></div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-7">
        <div class="card card-chart">
            <div class="card-header"><h3 class="card-title text-danger font-weight-bold m-0"><i class="fas fa-user-times mr-2"></i> Real-time Overdue Billings Tracking System</h3></div>
            <div class="card-body p-0">
                <div class="scrollable-table-wrapper">
                    <table class="table table-hover table-valign-middle m-0">
                        <thead>
                            <tr class="text-secondary" style="font-size:0.85rem;background:#f8fafc;">
                                <th>Mahasiswa</th><th>NIM</th><th>Kategori</th><th>Nominal</th><th>Jatuh Tempo</th><th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody style="font-size:0.85rem;">
                            @forelse($overdueList as $item)
                            <tr>
                                <td><strong>{{ $item->mahasiswa->nama ?? 'Tidak Ditemukan' }}</strong></td>
                                <td>{{ $item->mahasiswa->nim ?? $item->nim }}</td>
                                <td>
                                    <span style="border:1px solid #dcdcdc;padding:2px 8px;border-radius:4px;font-size:0.82rem;background:#f8f9fa;">
                                        {{ $item->kategori ?? '-' }}{{ $item->periode ? ' - '.$item->periode : '' }}
                                    </span>
                                </td>
                                <td style="color:#F04F52;font-weight:700;">Rp {{ number_format($item->total_tagihan / 1000000, 1, ',', '.') }} jt</td>
                                <td class="text-secondary">{{ $item->tanggal_jatuh_tempo ? \Carbon\Carbon::parse($item->tanggal_jatuh_tempo)->format('d-m-Y') : '-' }}</td>
                                <td>
                                    @php
                                        $nama  = $item->mahasiswa->nama ?? 'Mahasiswa';
                                        $kat   = $item->kategori ?? '';
                                        $per   = $item->periode ? " {$item->periode}" : '';
                                        $nom   = number_format($item->total_tagihan, 0, ',', '.');
                                        $msg   = urlencode("Halo {$nama}, tagihan {$kat}{$per} sebesar Rp {$nom} telah jatuh tempo. Mohon segera melakukan pembayaran.");
                                        $hp    = $item->mahasiswa->no_hp ?? '0';
                                        $waNum = '62' . ltrim($hp, '0');
                                    @endphp
                                    <a href="https://wa.me/{{ $waNum }}?text={{ $msg }}" target="_blank" class="btn btn-sm px-2" style="background:#25D366;color:#fff;font-weight:600;border-radius:6px;"><i class="fab fa-whatsapp mr-1"></i> WhatsApp</a>
                                </td>
                            </tr>
                            @empty
                            <tr><td colspan="6" class="text-center text-muted py-3"><i class="fas fa-check-circle text-success mr-2"></i>Tidak ada tagihan overdue</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('js')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2.0.0"></script>
<script>
$(document).ready(function() {
    function formatKustom(val) {
        if (!val || val === 0) return 'Rp 0';
        if (val >= 1000000000) { let n = val / 1000000000; return 'Rp ' + (n % 1 === 0 ? n.toFixed(0) : n.toFixed(1).replace('.', ',')) + ' M'; }
        if (val >= 1000000) { let n = val / 1000000; return 'Rp ' + (n % 1 === 0 ? n.toFixed(0) : n.toFixed(1).replace('.', ',')) + ' jt'; }
        if (val >= 1000) return 'Rp ' + (val / 1000).toFixed(0) + ' rb';
        return 'Rp ' + val;
    }

    $('#summary-paid').text(formatKustom({{ $totalRevenue }}));
    $('#summary-overdue').text(formatKustom({{ $overdueBills }}));
    $('#summary-open').text(formatKustom({{ $outstandingReceivables }}));

    const dataLunas   = @json($dataLunasBulanan);
    const dataBelum   = @json($dataBelumLunasBulanan);
    const dataOverdue = @json($dataOverdueBulanan);

    const ctxMixed = document.getElementById('mixedOverviewChart').getContext('2d');
    new Chart(ctxMixed, {
        data: {
            labels: ['Jan','Feb','Mar','Apr','Mei','Jun','Jul','Agu','Sep','Okt','Nov','Des'],
            datasets: [
                { type:'bar',  label:'Lunas',        backgroundColor:'#12BAAA', data:dataLunas,   barPercentage:0.5, order:2 },
                { type:'line', label:'Belum Lunas',  borderColor:'#F7B924', backgroundColor:'transparent', data:dataBelum,   tension:0.4, pointRadius:4, pointBackgroundColor:'#F7B924', order:1 },
                { type:'line', label:'Overdue Bills', borderColor:'#F04F52', backgroundColor:'transparent', data:dataOverdue, tension:0.4, pointRadius:4, pointBackgroundColor:'#F04F52', order:0 }
            ]
        },
        options: {
            responsive:true, maintainAspectRatio:false,
            plugins: {
                legend:{ display:false },
                datalabels: {
                    align:'top', anchor:'end',
                    color: ctx => ctx.dataset.borderColor || '#12BAAA',
                    backgroundColor:'rgba(255,255,255,0.85)',
                    borderRadius:4, padding:{ top:2, bottom:2, left:4, right:4 },
                    font:{ size:9, weight:'bold' },
                    formatter: v => v > 0 ? formatKustom(v) : ''
                }
            },
            scales: {
                y:{ display:false, grid:{ display:false } },
                x:{ display:true, grid:{ display:false }, ticks:{ font:{ weight:'bold' } } }
            },
            layout:{ padding:{ top:30, bottom:10, left:10, right:10 } }
        },
        plugins:[ChartDataLabels]
    });

    const donutLabels  = @json($donutLabels);
    const donutValues  = @json($donutValues);
    const colorPalette = ['#377EC0','#12BAAA','#F7891F','#5460AC','#95a5a6','#E28743','#218380'];

    const ctxDonut = document.getElementById('donutChartKategori').getContext('2d');
    new Chart(ctxDonut, {
        type:'doughnut',
        data: {
            labels: donutLabels,
            datasets:[{ data:donutValues, backgroundColor:colorPalette.slice(0,donutLabels.length), borderWidth:1.5, borderColor:'#ffffff' }]
        },
        options:{ responsive:true, maintainAspectRatio:false, plugins:{ legend:{ display:false }, datalabels:{ display:false } }, cutout:'72%' }
    });

    const totalDonut = donutValues.reduce((a,b) => Number(a)+Number(b), 0);
    let legendHtml = '';
    donutLabels.forEach((label, i) => {
        const val   = donutValues[i];
        const pct   = totalDonut > 0 ? ((val*100)/totalDonut).toFixed(0)+'%' : '0%';
        const warna = colorPalette[i % colorPalette.length];
        legendHtml += `
            <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:12px;font-size:0.85rem;">
                <div style="display:flex;align-items:center;gap:8px;">
                    <span style="width:10px;height:10px;background:${warna};border-radius:50%;flex-shrink:0;display:inline-block;"></span>
                    <span style="color:#4f5d73;font-weight:500;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;max-width:130px;" title="${label}">${label}</span>
                </div>
                <div style="display:flex;gap:12px;align-items:center;margin-left:auto;">
                    <span style="font-weight:700;color:#2c3e50;">${formatKustom(val)}</span>
                    <span style="color:#94a3b8;width:30px;text-align:right;font-weight:500;">${pct}</span>
                </div>
            </div>`;
    });
    document.getElementById('custom-donut-legend').innerHTML = legendHtml;
});
</script>
@endsection