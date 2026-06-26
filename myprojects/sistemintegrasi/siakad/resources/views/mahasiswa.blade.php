@extends('adminlte::page')

@section('title', 'Data Mahasiswa')

{{-- 1. TAMBAHKAN PROFIL LINGKARAN DI SIDEBAR MAHASISWA --}}
@section('sidebar_brand')
<div class="sidebar-profile-box">
    <div class="sidebar-avatar">
        <i class="fas fa-user-shield"></i>
    </div>
    <span class="sidebar-name">Nabila Hulwana</span>
    <span class="sidebar-role">Administrator SIAKAD</span>
</div>
@endsection

{{-- 2. TAMBAHKAN CSS GLOBAL BIAR JADI BIRU & MINDALIN SEARCH DATATABLES --}}
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
    <h1>Manajemen Mahasiswa (SIAKAD)</h1>
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

<form id="form-hapus-mhs" method="POST" action="" style="display:none;">
    @csrf
    @method('DELETE')
</form>

<div class="card">
    <div class="card-header">
        <h3 class="card-title">Daftar Mahasiswa</h3>
        <div class="card-tools">
            <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#modalTambah">
                <i class="fas fa-plus"></i> Tambah Data
            </button>
        </div>
    </div>
    <div class="card-body table-responsive">
        <table id="tableMahasiswa" class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>NIM</th>
                    <th>Nama Mahasiswa</th>
                    <th>Program Studi</th>
                    <th>Kelas</th>
                    <th>Dosen Wali</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($data as $item)
                <tr>
                    <td>{{ $item->nim }}</td>
                    <td>{{ $item->nama }}</td>
                    <td>
                        @if($item->id_prodi == 1) Sistem Informasi
                        @elseif($item->id_prodi == 2) Teknik Informatika
                        @elseif($item->id_prodi == 3) Teknik Komputer
                        @elseif($item->id_prodi == 4) TRPL
                        @else -
                        @endif
                    </td>
                    <td>{{ $item->kelas ?? '-' }}</td>
                    <td>{{ $item->dosenWali->nama ?? '-' }}</td>
                    <td>
                        @php
                            $status = $item->status_aktif ?? 'Aktif';
                            $badge = match($status) {
                                'Aktif'  => 'badge-success',
                                'Cuti'   => 'badge-warning',
                                'Lulus'  => 'badge-info',
                                'Keluar' => 'badge-danger',
                                default  => 'badge-secondary',
                            };
                        @endphp
                        <span class="badge {{ $badge }}">{{ $status }}</span>
                    </td>
                    <td style="white-space:nowrap;">
                        <button type="button" class="btn btn-xs btn-warning mx-1"
                            onclick="bukaEditMhs(
                                {{ $item->id }},
                                '{{ $item->nim }}',
                                '{{ addslashes($item->nama) }}',
                                '{{ $item->id_prodi }}',
                                '{{ $item->kelas ?? '' }}',
                                '{{ $item->dosen_wali_id ?? '' }}',
                                '{{ $item->status_aktif ?? 'Aktif' }}'
                            )">
                            <i class="fa fa-pen"></i>
                        </button>
                        <button type="button" class="btn btn-xs btn-danger mx-1"
                            onclick="hapusMhs('{{ url('/mahasiswa/hapus/'.$item->id) }}')">
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
<div class="modal fade" id="modalTambah" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h5 class="modal-title">Tambah Data Mahasiswa</h5>
                <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
            </div>
            <form action="/mahasiswa/simpan" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label>NIM</label>
                        <input type="text" name="nim" class="form-control" required placeholder="Contoh: 20240001">
                    </div>
                    <div class="form-group">
                        <label>Nama Mahasiswa</label>
                        <input type="text" name="nama" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Program Studi</label>
                        <select name="prodi" class="form-control" required>
                            <option value="">-- pilih prodi --</option>
                            <option value="1">Sistem Informasi</option>
                            <option value="2">Teknik Informatika</option>
                            <option value="3">Teknik Komputer</option>
                            <option value="4">TRPL</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Kelas</label>
                        <input type="text" name="kelas" class="form-control" placeholder="Contoh: TRPL24A, SI23B">
                    </div>
                    <div class="form-group">
                        <label>Dosen Wali</label>
                        <select name="dosen_wali_id" class="form-control select2-dosen-wali" style="width:100%">
                            <option value="">-- pilih dosen wali --</option>
                            @foreach($dosen as $d)
                                <option value="{{ $d->id }}">{{ $d->nip }} - {{ $d->nama }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Status Mahasiswa</label>
                        <select name="status_aktif" class="form-control" required>
                            <option value="Aktif">Aktif</option>
                            <option value="Cuti">Cuti</option>
                            <option value="Lulus">Lulus</option>
                            <option value="Keluar">Keluar</option>
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
<div class="modal fade" id="modalEdit" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-warning">
                <h5 class="modal-title">Edit Data Mahasiswa</h5>
                <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
            </div>
            <form id="formEdit" method="POST" action="">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label>NIM</label>
                        <input type="text" name="nim" id="edit_nim" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Nama Mahasiswa</label>
                        <input type="text" name="nama" id="edit_nama" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Program Studi</label>
                        <select name="prodi" id="edit_prodi" class="form-control" required>
                            <option value="1">Sistem Informasi</option>
                            <option value="2">Teknik Informatika</option>
                            <option value="3">Teknik Komputer</option>
                            <option value="4">TRPL</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Kelas</label>
                        <input type="text" name="kelas" id="edit_kelas" class="form-control" placeholder="Contoh: TRPL24A, SI23B">
                    </div>
                    <div class="form-group">
                        <label>Dosen Wali</label>
                        <select name="dosen_wali_id" id="edit_dosen_wali_id" class="form-control" style="width:100%">
                            <option value="">-- pilih dosen wali --</option>
                            @foreach($dosen as $d)
                                <option value="{{ $d->id }}">{{ $d->nip }} - {{ $d->nama }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Status Mahasiswa</label>
                        <select name="status_aktif" id="edit_status" class="form-control" required>
                            <option value="Aktif">Aktif</option>
                            <option value="Cuti">Cuti</option>
                            <option value="Lulus">Lulus</option>
                            <option value="Keluar">Keluar</option>
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
function bukaEditMhs(id, nim, nama, prodi, kelas, dosenWaliId, status) {
    document.getElementById('formEdit').action = '/mahasiswa/update/' + id;
    document.getElementById('edit_nim').value = nim;
    document.getElementById('edit_nama').value = nama;
    document.getElementById('edit_prodi').value = prodi;
    document.getElementById('edit_kelas').value = kelas;
    document.getElementById('edit_dosen_wali_id').value = dosenWaliId;
    document.getElementById('edit_status').value = status;
    $('#modalEdit').modal('show');
}

function hapusMhs(action) {
    if (confirm('Yakin hapus data mahasiswa ini?')) {
        document.getElementById('form-hapus-mhs').action = action;
        document.getElementById('form-hapus-mhs').submit();
    }
}

$(document).ready(function() {
    $('#tableMahasiswa').DataTable({
        responsive: true,
        autoWidth: false,
        language: { url: '//cdn.datatables.net/plug-ins/1.13.4/i18n/id.json' }
    });

    $('.select2-dosen-wali').select2({
        theme: 'bootstrap4',
        dropdownParent: $('#modalTambah')
    });
});
</script>
@endsection