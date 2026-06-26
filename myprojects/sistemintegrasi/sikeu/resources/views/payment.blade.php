@extends('adminlte::page')

@section('title', 'Manajemen Tagihan')

@section('content_header')
    <h1>Manajemen Tagihan (SIKEU)</h1>
@endsection

@section('css')
<style>
.snap-midtrans-modal, 
    #snap-midtrans {
        z-index: 999999 !important;
    }

    /* Memastikan tombol close memiliki area klik yang bersih */
    .snap-midtrans-modal .close-button {
        z-index: 1000000 !important;
        pointer-events: auto !important;
    }
    .select2-container .select2-selection--single { height: 38px !important; }
    .select2-container--bootstrap4 .select2-selection--single .select2-selection__rendered { line-height: 38px !important; }
    
    /* Sinkronisasi warna badge dengan UI Dashboard utama */
    .badge-lunas { background-color: #12BAAA !important; color: #fff; }
    .badge-belum-lunas { background-color: #F7B924 !important; color: #fff; }
    .badge-menunggu { background-color: #F04F52 !important; color: #fff; }

/* 1. KUSTOMISASI WARNA UTAMA SIDEBAR (GRADIENT BIRU) & BACKGROUND GLOBAL */
.main-sidebar, .sidebar { 
    background: linear-gradient(135deg, #377EC0 0%, #205081 100%) !important; 
}
.content-wrapper { 
    background: #edf1f7 !important; 
}

/* 2. SEMBUNYIKAN LOGO DEFAULT ADMINLTE (Membuat box profil kustom Anda bekerja) */
.main-sidebar .brand-link { 
    display: none !important; 
}

/* 3. NAVIGASI MENU UTAMA MELAYANG RAPI */
.sidebar .nav-sidebar .nav-item .nav-link {
    color: rgba(255,255,255,0.9) !important;
    border-radius: 8px !important;
    margin: 4px 14px !important;
    padding: 10px 14px !important;
    font-size: 0.85rem;
    width: calc(100% - 28px) !important;
    transition: all 0.2s ease;
}

.sidebar .nav-sidebar .nav-item .nav-link:hover,
.sidebar .nav-sidebar .nav-item .nav-link.active { 
    background: rgba(255,255,255,0.18) !important; 
    color: #fff !important; 
}

/* Warna Icon Emas saat Aktif */
.sidebar .nav-sidebar .nav-item .nav-link.active .nav-icon { 
    color: #FBDF54 !important; 
}

/* 4. TOPBAR NAVBAR CLEAN WHITE */
.main-header.navbar { 
    background: #fff !important; 
    border-bottom: 1px solid #dce6f0 !important; 
    box-shadow: 0 2px 6px rgba(55,126,192,0.05); 
    height: 57px; 
}
</style>
@endsection

@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}">

@if(session('success'))
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            Swal.fire('Berhasil!', "{{ session('success') }}", 'success');
        });
    </script>
@endif
@if(session('error'))
    <div class="alert alert-danger">{{ session('error') }}</div>
@endif
@if(session('info'))
    <div class="alert alert-info">{{ session('info') }}</div>
@endif

{{-- Form hapus tersembunyi --}}
<form id="form-hapus" method="POST" action="" style="display:none;">
    @csrf
    @method('DELETE')
</form>

<div class="card">
    <div class="card-header">
        <h3 class="card-title">Daftar Tagihan</h3>
        <button type="button" class="btn btn-primary float-right" data-toggle="modal" data-target="#modal-tagihan">
            <i class="fas fa-plus"></i> Tambah Tagihan
        </button>
    </div>
<table id="table-tagihan" class="table table-bordered table-striped">
    <thead>
        <tr>
            <th>Mahasiswa</th>
            <th>NIM</th>
            <th>Kategori</th>
            <th>Total Tagihan</th>
            <th>Status</th>
            <th>Jatuh Tempo</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($listTagihan as $item)
        <tr>
            <td>{{ $item->nama_mahasiswa ?? '-' }}</td>
            <td>{{ $item->nim_mahasiswa ?? '-' }}</td>
            <td>
                {{ $item->kategori ?? '-' }}
                @if($item->kategori === 'SPP' && $item->periode)
                    - {{ $item->periode }}
                @endif
            </td>
            <td>Rp {{ number_format($item->total_tagihan, 0, ',', '.') }}</td>
            <td>
                @if($item->status_bayar == 'Lunas')
                    <span class="badge badge-lunas">Lunas</span>
                @elseif($item->status_bayar == 'Pending' || $item->status_bayar == 'Menunggu')
                    <span class="badge badge-menunggu">Overdue</span>
                @else
                    <span class="badge badge-belum-lunas">{{ $item->status_bayar }}</span>
                @endif
            </td>
            <td>{{ $item->tanggal_jatuh_tempo ? \Carbon\Carbon::parse($item->tanggal_jatuh_tempo)->format('d-m-Y') : '-' }}</td>
            <td style="white-space:nowrap;">
                @if($item->status_bayar != 'Lunas')
                    <form action="{{ url('/bayartagihan/'.$item->id) }}" method="POST" style="display:inline;">
                        @csrf
                        <button type="submit" class="btn btn-primary btn-sm" title="Bayar">
                            <i class="fas fa-credit-card"></i>
                        </button>
                    </form>
                @else
                    <button class="btn btn-success btn-sm" disabled title="Lunas">
                        <i class="fas fa-check"></i>
                    </button>
                @endif
                <a href="{{ url('/cekstatus/'.$item->id) }}" class="btn btn-info btn-sm" title="Cek Status">
                    <i class="fas fa-search"></i>
                </a>
                <button type="button"
                    class="btn btn-warning btn-sm"
                    title="Edit"
                    onclick="bukaEdit(
                        '{{ url('/updatetagihan/'.$item->id) }}',
                        '{{ $item->kategori }}',
                        '{{ $item->periode }}',
                        '{{ $item->total_tagihan }}',
                        '{{ $item->tanggal_jatuh_tempo }}'
                    )">
                    <i class="fas fa-pencil-alt"></i>
                </button>
                <button type="button"
                    class="btn btn-danger btn-sm"
                    title="Hapus"
                    onclick="konfirmasiHapus('{{ url('/hapustagihan/'.$item->id) }}')">
                    <i class="fas fa-trash"></i>
                </button>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
    </div>
</div>

{{-- MODAL TAMBAH --}}
<div class="modal fade" id="modal-tagihan" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h5 class="modal-title">Tambah Tagihan Baru</h5>
                <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
            </div>
            <form method="POST" action="/simpantagihan">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Mahasiswa</label>
                                <select name="student_id" id="student_id" class="form-control select2" style="width:100%;" required>
                                    <option value="">-- pilih mahasiswa --</option>
                                    @foreach($data as $mhs)
                                        <option value="{{ $mhs->id }}" data-nim="{{ $mhs->nim }}">
                                            {{ $mhs->nim }} - {{ $mhs->nama }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>NIM</label>
                                <input type="text" id="nim_display" class="form-control" readonly>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Kategori</label>
                                <select name="kategori" id="kategori" class="form-control" required onchange="togglePeriode()">
                                    <option value="">-- pilih kategori --</option>
                                    <option value="SPP">SPP</option>
                                    <option value="Magang">Magang</option>
                                    <option value="Skripsi">Skripsi</option>
                                    <option value="UJK">UJK</option>
                                    <option value="EPT">EPT</option>
                                    <option value="Dana Pengembangan">Dana Pengembangan</option>
                                    <option value="Cuti Semester">Cuti Semester</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6" id="periode_wrapper" style="display:none;">
                            <div class="form-group">
                                <label>Periode Semester</label>
                                <select name="periode" id="periode" class="form-control"></select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Nominal (Rp)</label>
                                <input type="number" name="amount" class="form-control" placeholder="Contoh: 3000000" min="1" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Tanggal Jatuh Tempo</label>
                                <input type="date" name="tanggal_jatuh_tempo" class="form-control">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-primary">Simpan Tagihan</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- MODAL EDIT --}}
<div class="modal fade" id="modal-edit" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-warning">
                <h5 class="modal-title">Edit Tagihan</h5>
                <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
            </div>
            <form method="POST" action="" id="form-edit">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Kategori</label>
                                <select name="kategori" id="edit_kategori" class="form-control" required onchange="toggleEditPeriode()">
                                    <option value="SPP">SPP</option>
                                    <option value="Magang">Magang</option>
                                    <option value="Skripsi">Skripsi</option>
                                    <option value="UJK">UJK</option>
                                    <option value="EPT">EPT</option>
                                    <option value="Dana Pengembangan">Dana Pengembangan</option>
                                    <option value="Cuti Semester">Cuti Semester</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6" id="edit_periode_wrapper" style="display:none;">
                            <div class="form-group">
                                <label>Periode Semester</label>
                                <input type="text" name="periode" id="edit_periode" class="form-control" placeholder="Contoh: 2023/1">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Jumlah (Rp)</label>
                                <input type="number" name="amount" id="edit_amount" class="form-control" min="1" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Tanggal Jatuh Tempo</label>
                                <input type="date" name="tanggal_jatuh_tempo" id="edit_jatuh" class="form-control">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-warning">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('js')
<script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ env('Mid-client-Jw0m2Ca9dThy1Y3A') }}"></script>
<script>

// =============================================
// FUNGSI GLOBAL
// =============================================

function bukaEdit(action, kategori, periode, total, jatuh) {
    document.getElementById('form-edit').action = action;
    document.getElementById('edit_kategori').value = kategori || 'SPP';
    document.getElementById('edit_amount').value = total || '';
    document.getElementById('edit_jatuh').value = jatuh || '';
    document.getElementById('edit_periode').value = periode || '';
    toggleEditPeriode();
    $('#modal-edit').modal('show');
}

function konfirmasiHapus(action) {
    if (confirm('Hapus tagihan ini? Data tidak bisa dikembalikan.')) {
        document.getElementById('form-hapus').action = action;
        document.getElementById('form-hapus').submit();
    }
}

function toggleEditPeriode() {
    var val = document.getElementById('edit_kategori').value;
    document.getElementById('edit_periode_wrapper').style.display = (val === 'SPP') ? 'block' : 'none';
}

function generateSemesterOptions() {
    var opts = [];
    for (var i = 1; i <= 8; i++) {
        opts.push('Semester ' + i);
    }
    return opts;
}

// Fungsi tunggal yang bersih tanpa konflik tumpang tindih
function togglePeriode() {
    var val = document.getElementById('kategori').value;
    var wrapper = document.getElementById('periode_wrapper');
    var periodeSelect = document.getElementById('periode');

    if (val === 'SPP') {
        if (periodeSelect.options.length === 0) {
            generateSemesterOptions().forEach(function(s) {
                var opt = document.createElement('option');
                opt.value = s;
                opt.textContent = s;
                periodeSelect.appendChild(opt);
            });
        }
        wrapper.style.display = 'block';
    } else {
        wrapper.style.display = 'none';
        periodeSelect.value = '';
    }
}

// =============================================
// JQUERY — Hanya untuk Init Plugin Datatable & Select2
// =============================================
$(document).ready(function() {

@if(session('snapToken'))
window.snap.pay("{{ session('snapToken') }}", {
    onSuccess: function(result) {
        Swal.fire('Sukses', 'Pembayaran berhasil!', 'success').then(() => location.reload());
    },
    onPending: function(result) {
        Swal.fire('Info', 'Menunggu pembayaran...', 'info');
    },
    onError: function(result) {
        Swal.fire('Error', 'Pembayaran gagal!', 'error');
    },
    onClose: function() {
        // SOLUSI: Jika tombol X tidak merespons, arahkan user untuk refresh halaman
        Swal.fire({
            title: 'Pembayaran Dibatalkan',
            text: 'Klik tombol di bawah ini untuk menutup jendela pembayaran.',
            icon: 'warning',
            confirmButtonText: 'Tutup & Refresh Halaman'
        }).then((result) => {
            if (result.isConfirmed) {
                location.reload(); // Ini akan membuang iframe Midtrans secara paksa
            }
        });
    }
});
@endif

    $('#table-tagihan').DataTable({
        responsive: true,
        autoWidth: false,
        language: { url: "//cdn.datatables.net/plug-ins/1.10.21/i18n/Indonesian.json" }
    });

    $('#student_id').select2({
        theme: 'bootstrap4',
        placeholder: "-- pilih mahasiswa --",
        allowClear: true,
        dropdownParent: $('#modal-tagihan')
    });

    $('#student_id').on('select2:select select2:unselect', function() {
        var nim = $(this).find(':selected').data('nim') || '';
        $('#nim_display').val(nim);
    });

    $('#modal-tagihan').on('hidden.bs.modal', function() {
        $(this).find('form').trigger('reset');
        $('#nim_display').val('');
        $('#student_id').val(null).trigger('change');
        $('#periode_wrapper').hide();
    });
});
</script>
@endsection
