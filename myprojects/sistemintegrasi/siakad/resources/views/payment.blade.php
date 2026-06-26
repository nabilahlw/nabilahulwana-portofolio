@extends('adminlte::page')

@section('title', 'Data Pembayaran')

{{-- 1. PROFIL LINGKARAN DI SIDEBAR PAYMENT --}}
@section('sidebar_brand')
<div class="sidebar-profile-box">
    <div class="sidebar-avatar">
        <i class="fas fa-user-shield"></i>
    </div>
    <span class="sidebar-name">Nabila Hulwana</span>
    <span class="sidebar-role">Administrator SIAKAD</span>
</div>
@endsection

{{-- 2. THEME BLUE GLOBAL & AUTOMATIC DATA TABLES SEARCH ALIGNMENT --}}
@push('css')
<style>
/* WARNA UTAMA SIDEBAR & BACKGROUND GLOBAL */
.main-sidebar, .sidebar { background-color: #377EC0 !important; }
.content-wrapper { background: #edf1f7 !important; }
.main-sidebar .brand-link { display: none !important; }

/* NAVIGASI MENU UTAMA MELAYANG RAPI */
.sidebar .nav-sidebar .nav-item .nav-link {
    color: rgba(255,255,255,0.9) !important; 
    border-radius: 8px !important;
    margin: 4px 14px !important; 
    padding: 10px 14px !important; 
    font-size: 0.85rem; 
    transition: all 0.2s ease;
    width: calc(100% - 28px) !important;
}
.sidebar .nav-sidebar .nav-item .nav-link:hover,
.sidebar .nav-sidebar .nav-item .nav-link.active { 
    background: rgba(255,255,255,0.18) !important; 
    color: #fff !important; 
}
.sidebar .nav-sidebar .nav-item .nav-link.active { box-shadow: 0 2px 6px rgba(0,0,0,0.08); }
.sidebar .nav-sidebar .nav-item .nav-link .nav-icon { color: rgba(255,255,255,0.7) !important; }
.sidebar .nav-sidebar .nav-item .nav-link.active .nav-icon { color: #FBDF54 !important; }
.sidebar .nav-header { color: rgba(255,255,255,0.5) !important; font-size: 0.68rem !important; letter-spacing: 1.2px !important; padding: 12px 24px 4px !important; }

/* SEARCH BOX SIDEBAR UTAMA */
.sidebar-search-block { padding: 0 14px; margin-bottom: 15px; }
.sidebar .form-control-sidebar { background: rgba(0,0,0,0.1) !important; border: 1px solid rgba(255,255,255,0.15) !important; color: #fff !important; border-radius: 8px 0 0 8px !important; height: 35px; }
.sidebar .form-control-sidebar::placeholder { color: rgba(255,255,255,0.55) !important; }
.sidebar .btn-sidebar { background: rgba(0,0,0,0.1) !important; border: 1px solid rgba(255,255,255,0.15) !important; border-left: none !important; color: rgba(255,255,255,0.6) !important; border-radius: 0 8px 8px 0 !important; height: 35px; }

/* TOPBAR CLEAN WHITE */
.main-header.navbar { background: #fff !important; border-bottom: 1px solid #dce6f0 !important; box-shadow: 0 2px 6px rgba(55,126,192,0.05); height: 57px; }

/* TRICK CSS: MEMAKSA KOLOM SEARCH PINDAH KE SAMPING SHOW ENTRIES */
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
.dataTables_wrapper .dataTables_length { margin-right: 0 !important; }
.dataTables_wrapper .dataTables_filter { margin-left: 0 !important; text-align: left !important; }
.dataTables_wrapper .dataTables_filter label { margin-bottom: 0 !important; display: flex !important; align-items: center !important; gap: 5px; }
</style>
@endpush

@section('content_header')
    <h1>Data Pembayaran Mahasiswa (dari SIKEU)</h1>
@endsection

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Daftar Tagihan & Pembayaran</h3>
    </div>
    <div class="card-body">
        <table class="table table-bordered" id="tablePembayaran">
            <thead>
                <tr>
                    <th>NIM</th>
                    <th>Nama Mahasiswa</th>
                    <th>Kategori</th>
                    <th>Total Tagihan</th>
                    <th>Status</th>
                    <th>Jatuh Tempo</th>
                </tr>
            </thead>
            <tbody>
                @foreach($tagihan as $item)
                <tr>
                    <td>{{ $item->nim ?? 'NIM di tagihan NULL' }}</td> 
                    <td>{{ $item->mahasiswa ? $item->mahasiswa->nama : 'Relasi Gagal' }}</td>
                    <td>{{ $item->kategori }}</td>
                    <td>Rp {{ number_format($item->total_tagihan, 0, ',', '.') }}</td>
                    
                    {{-- BAGIAN STATUS YANG BARU --}}
                    <td>
                        @php
                            $jatuhTempo = \Carbon\Carbon::parse($item->tanggal_jatuh_tempo);
                            $hariIni = \Carbon\Carbon::today();
                            $isOverdue = ($item->status_bayar !== 'Lunas' && $jatuhTempo->lt($hariIni));
                        @endphp

                        @if($item->status_bayar == 'Lunas')
                            <span class="badge badge-success" style="background-color: #28a745; color: white; padding: 5px 10px; border-radius: 4px;">Lunas</span>
                        
                        @elseif($isOverdue)
                            <span class="badge badge-danger" style="background-color: #dc3545; color: white; padding: 5px 10px; border-radius: 4px;">Overdue</span>
                        
                        @elseif($item->status_bayar == 'Pending')
                            <span class="badge badge-warning" style="background-color: #ffc107; color: black; padding: 5px 10px; border-radius: 4px;">Menunggu Pembayaran</span>
                        
                        @else
                            <span class="badge badge-warning" style="background-color: #ffc107; color: black; padding: 5px 10px; border-radius: 4px;">Belum Lunas</span>
                        @endif
                    </td>

                    <td>{{ $item->tanggal_jatuh_tempo ? \Carbon\Carbon::parse($item->tanggal_jatuh_tempo)->format('d-m-Y') : '-' }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection

@section('js')
<script>
$(document).ready(function() {
    $('#tablePembayaran').DataTable({
        responsive: true,
        autoWidth: false,
        language: { url: '//cdn.datatables.net/plug-ins/1.13.4/i18n/id.json' }
    });
});
</script>
@endsection