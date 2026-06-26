@extends('adminlte::page')

@section('title', 'Data Mata Kuliah')

{{-- 1. PROFIL LINGKARAN DI SIDEBAR MATA KULIHAH --}}
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
    <h1>Manajemen Mata Kuliah (SIAKAD)</h1>
@endsection

@section('content')

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

<form id="form-hapus-mk" method="POST" action="" style="display:none;">
    @csrf
    @method('DELETE')
</form>

<div class="card">
    <div class="card-header">
        <h3 class="card-title">Daftar Mata Kuliah</h3>
        <div class="card-tools">
            <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#modalTambahMK">
                <i class="fas fa-plus"></i> Tambah Mata Kuliah
            </button>
        </div>
    </div>
    <div class="card-body table-responsive">
        <table class="table table-bordered table-striped" id="tableMataKuliah">
            <thead>
                <tr>
                    <th>Kode MK</th>
                    <th>Nama Mata Kuliah</th>
                    <th>SKS</th>
                    <th>Semester</th>
                    <th>Dosen Pengampu</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($data as $item)
                <tr>
                    <td><span class="badge badge-dark">{{ $item->kode_mk }}</span></td>
                    <td>{{ $item->nama_mk }}</td>
                    <td>{{ $item->sks }} SKS</td>
                    <td>{{ $item->semester ?? '-' }}</td>
                    <td>{{ $item->dosenPengampu->nama ?? '-' }}</td>
                    <td style="white-space:nowrap;">
                        <button type="button" class="btn btn-xs btn-warning mx-1"
                            onclick="bukaEditMK(
                                {{ $item->id }},
                                '{{ $item->kode_mk }}',
                                '{{ addslashes($item->nama_mk) }}',
                                '{{ $item->sks }}',
                                '{{ $item->semester }}',
                                '{{ $item->nomor_urut ?? '' }}',
                                '{{ $item->dosen_pengampu_id ?? '' }}'
                            )">
                            <i class="fa fa-pen"></i>
                        </button>
                        <button type="button" class="btn btn-xs btn-danger mx-1"
                            onclick="hapusMK('{{ url('/matakuliah/hapus/'.$item->id) }}')">
                            <i class="fa fa-trash"></i>
                        </button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

{{-- Modal Tambah --}}
<div class="modal fade" id="modalTambahMK" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h5 class="modal-title">Tambah Mata Kuliah</h5>
                <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
            </div>
            <form action="/matakuliah/simpan" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label>Kode MK <small class="text-muted">(otomatis terisi)</small></label>
                        <input type="text" name="kode_mk" id="kode_mk_display" class="form-control font-weight-bold" readonly required>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Program Studi</label>
                                <select id="mk_prodi" class="form-control" onchange="generateKodeMK()">
                                    <option value="">-- pilih --</option>
                                    <option value="SI">Sistem Informasi</option>
                                    <option value="TIF">Technical Informatics</option>
                                    <option value="TK">Teknik Komputer</option>
                                    <option value="TRPL">TRPL</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Semester (1-8)</label>
                                <select name="semester" id="mk_semester" class="form-control" onchange="generateKodeMK()" required>
                                    <option value="">-- pilih --</option>
                                    @for($i = 1; $i <= 8; $i++)
                                        <option value="{{ $i }}">Semester {{ $i }}</option>
                                    @endfor
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Nomor Urut MK (2 digit)</label>
                                <input type="number" name="nomor_urut" id="mk_nomor_urut" class="form-control" min="1" max="99" placeholder="Contoh: 1" onchange="generateKodeMK()" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Jumlah SKS</label>
                                <select name="sks" id="mk_sks" class="form-control" onchange="generateKodeMK()" required>
                                    <option value="">-- pilih --</option>
                                    <option value="1">1 SKS</option>
                                    <option value="2">2 SKS</option>
                                    <option value="3">3 SKS</option>
                                    <option value="4">4 SKS</option>
                                    <option value="6">6 SKS</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Nama Mata Kuliah</label>
                        <select name="nama_mk" class="form-control" required>
                            <option value="">-- pilih mata kuliah --</option>
                            <option value="Pemrograman Web">Pemrograman Web</option>
                            <option value="Basis Data">Basis Data</option>
                            <option value="Struktur Data">Struktur Data</option>
                            <option value="Algoritma dan Pemrograman">Algoritma dan Pemrograman</option>
                            <option value="Sistem Operasi">Sistem Operasi</option>
                            <option value="Jaringan Komputer">Jaringan Komputer</option>
                            <option value="Kecerdasan Buatan">Kecerdasan Buatan</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Dosen Pengampu</label>
                        <select name="dosen_pengampu_id" class="form-control select2-dosen-mk" style="width:100%">
                            <option value="">-- pilih dosen --</option>
                            @foreach($dosen as $d)
                                <option value="{{ $d->id }}">{{ $d->nip }} - {{ $d->nama }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- Modal Edit --}}
<div class="modal fade" id="modalEditMK" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-warning">
                <h5 class="modal-title">Edit Mata Kuliah</h5>
                <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
            </div>
            <form id="formEditMK" method="POST" action="">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label>Kode MK</label>
                        <input type="text" name="kode_mk" id="edit_kode_mk" class="form-control font-weight-bold" required>
                    </div>
                    <div class="form-group">
                        <label>Nama Mata Kuliah</label>
                        <select name="nama_mk" id="edit_nama_mk" class="form-control" required>
                            <option value="">-- pilih mata kuliah --</option>
                            <option value="Pemrograman Web">Pemrograman Web</option>
                            <option value="Basis Data">Basis Data</option>
                            <option value="Struktur Data">Struktur Data</option>
                            <option value="Algoritma dan Pemrograman">Algoritma dan Pemrograman</option>
                            <option value="Sistem Operasi">Sistem Operasi</option>
                            <option value="Jaringan Komputer">Jaringan Komputer</option>
                            <option value="Kecerdasan Buatan">Kecerdasan Buatan</option>
                        </select>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Semester</label>
                                <select name="semester" id="edit_semester" class="form-control" required>
                                    @for($i = 1; $i <= 8; $i++)
                                        <option value="{{ $i }}">Semester {{ $i }}</option>
                                    @endfor
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Jumlah SKS</label>
                                <select name="sks" id="edit_sks" class="form-control" required>
                                    <option value="1">1 SKS</option>
                                    <option value="2">2 SKS</option>
                                    <option value="3">3 SKS</option>
                                    <option value="4">4 SKS</option>
                                    <option value="6">6 SKS</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Dosen Pengampu</label>
                        <select name="dosen_pengampu_id" id="edit_dosen_pengampu_id" class="form-control" style="width:100%">
                            <option value="">-- pilih dosen --</option>
                            @foreach($dosen as $d)
                                <option value="{{ $d->id }}">{{ $d->nip }} - {{ $d->nama }}</option>
                            @endforeach
                        </select>
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
<script>
function generateKodeMK() {
    var prodi   = document.getElementById('mk_prodi').value;
    var sem     = document.getElementById('mk_semester').value;
    var nomor   = document.getElementById('mk_nomor_urut').value;
    var sks     = document.getElementById('mk_sks').value;

    if (prodi && sem && nomor && sks) {
        var nomorPad = String(parseInt(nomor)).padStart(2, '0');
        var kode = prodi + sem + nomorPad + sks;
        document.getElementById('kode_mk_display').value = kode;
    } else {
        document.getElementById('kode_mk_display').value = '';
    }
}

function bukaEditMK(id, kodeMK, namaMK, sks, semester, nomorUrut, dosenId) {
    document.getElementById('formEditMK').action = '/matakuliah/' + id;
    document.getElementById('edit_kode_mk').value = kodeMK;
    document.getElementById('edit_nama_mk').value = namaMK;
    document.getElementById('edit_sks').value = sks;
    document.getElementById('edit_semester').value = semester;
    document.getElementById('edit_dosen_pengampu_id').value = dosenId;
    $('#modalEditMK').modal('show');
}

function hapusMK(action) {
    if (confirm('Yakin hapus mata kuliah ini?')) {
        document.getElementById('form-hapus-mk').action = action;
        document.getElementById('form-hapus-mk').submit();
    }
}

$(document).ready(function() {
    $('#tableMataKuliah').DataTable({
        responsive: true,
        autoWidth: false,
        language: { url: '//cdn.datatables.net/plug-ins/1.13.4/i18n/id.json' }
    });

    $('.select2-dosen-mk').select2({
        theme: 'bootstrap4',
        dropdownParent: $('#modalTambahMK')
    });
});
</script>
@endsection