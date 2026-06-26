@extends('adminlte::page')

@section('title', 'Data Jabatan')

@section('content_header')
    <h1>Manajemen Jabatan Dosen (SIMPEG)</h1>
@endsection
@push('css')
<style>
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
@endpush
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

<div class="card">
    <div class="card-header">
        <h3 class="card-title">Daftar Jabatan</h3>
        <div class="card-tools">
            <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#modalTambahJabatan">
                <i class="fas fa-plus"></i> Tambah Jabatan
            </button>
        </div>
    </div>
    <div class="card-body">
        <table class="table table-bordered table-striped" id="tableJabatan">
            <thead>
                <tr>
                    <th>Nama Dosen</th>
                    <th>NIP</th>
                    <th>Jabatan</th>
                    <th>Tanggal Pengangkatan</th>
                    <th>TMT Akhir</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($data as $item)
                <tr>
                    <td>{{ $item->pegawai->nama ?? '-' }}</td>
                    <td>{{ $item->pegawai->nip ?? '-' }}</td>
                    <td>{{ $item->nama_jabatan }}</td>
                    <td>{{ \Carbon\Carbon::parse($item->tanggal_pengangkatan)->format('d-m-Y') }}</td>
                    <td>{{ $item->tmt_akhir ? \Carbon\Carbon::parse($item->tmt_akhir)->format('d-m-Y') : '-' }}</td>
                    <td>
                        @if(!$item->tmt_akhir || \Carbon\Carbon::parse($item->tmt_akhir)->isFuture())
                            <span class="badge badge-success">Aktif</span>
                        @else
                            <span class="badge badge-secondary">Berakhir</span>
                        @endif
                    </td>
                    <td style="white-space:nowrap;">
                        <button type="button"
                            class="btn btn-xs btn-warning mx-1"
                            title="Edit"
                            onclick="bukaEditJabatan(
                                {{ $item->id }},
                                {{ $item->pegawai_id }},
                                '{{ $item->nama_jabatan }}',
                                '{{ $item->tanggal_pengangkatan ? \Carbon\Carbon::parse($item->tanggal_pengangkatan)->format('Y-m-d') : '' }}',
                                '{{ $item->tmt_akhir ? \Carbon\Carbon::parse($item->tmt_akhir)->format('Y-m-d') : '' }}'
                            )">
                            <i class="fa fa-pen"></i>
                        </button>
                        <button type="button"
                            class="btn btn-xs btn-danger mx-1"
                            title="Hapus"
                            onclick="hapusJabatan('{{ url('/jabatan/hapus/'.$item->id) }}')">
                            <i class="fa fa-trash"></i>
                        </button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

{{-- Form hapus tersembunyi --}}
<form id="form-hapus-jabatan" method="POST" action="" style="display:none;">
    @csrf
    @method('DELETE')
</form>

{{-- Modal Tambah --}}
<div class="modal fade" id="modalTambahJabatan" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h5 class="modal-title">Tambah Jabatan Dosen</h5>
                <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
            </div>
            <form action="/jabatan/simpan" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label>Dosen</label>
                        <select name="pegawai_id" class="form-control select2-dosen" style="width:100%" required>
                            <option value="">-- pilih dosen --</option>
                            @foreach($dosen as $d)
                                <option value="{{ $d->id }}">{{ $d->nip }} - {{ $d->nama }} ({{ $d->status_kepegawaian }})</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Jabatan</label>
                        <select name="nama_jabatan" class="form-control" required>
                            <option value="">-- pilih jabatan --</option>
                            <option value="Tenaga Pengajar">Tenaga Pengajar</option>
                            <option value="Asisten Ahli">Asisten Ahli</option>
                            <option value="Lektor">Lektor</option>
                            <option value="Lektor Kepala">Lektor Kepala</option>
                            <option value="Guru Besar">Guru Besar</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Tanggal Pengangkatan</label>
                        <input type="date" name="tanggal_pengangkatan" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>TMT Akhir (opsional)</label>
                        <input type="date" name="tmt_akhir" class="form-control">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-success">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- Modal Edit --}}
<div class="modal fade" id="modalEditJabatan" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-warning">
                <h5 class="modal-title">Edit Jabatan Dosen</h5>
                <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
            </div>
            <form id="formEditJabatan" method="POST" action="">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label>Dosen</label>
                        <select name="pegawai_id" id="edit_pegawai_id" class="form-control" required>
                            <option value="">-- pilih dosen --</option>
                            @foreach($dosen as $d)
                                <option value="{{ $d->id }}">{{ $d->nip }} - {{ $d->nama }} ({{ $d->status_kepegawaian }})</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Jabatan</label>
                        <select name="nama_jabatan" id="edit_nama_jabatan" class="form-control" required>
                            <option value="Tenaga Pengajar">Tenaga Pengajar</option>
                            <option value="Asisten Ahli">Asisten Ahli</option>
                            <option value="Lektor">Lektor</option>
                            <option value="Lektor Kepala">Lektor Kepala</option>
                            <option value="Guru Besar">Guru Besar</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Tanggal Pengangkatan</label>
                        <input type="date" name="tanggal_pengangkatan" id="edit_tanggal_pengangkatan" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>TMT Akhir (opsional)</label>
                        <input type="date" name="tmt_akhir" id="edit_tmt_akhir" class="form-control">
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

function bukaEditJabatan(id, pegawaiId, namaJabatan, tglPengangkatan, tmtAkhir) {
    document.getElementById('formEditJabatan').action = '/jabatan/' + id;
    document.getElementById('edit_pegawai_id').value = pegawaiId;
    document.getElementById('edit_nama_jabatan').value = namaJabatan;
    document.getElementById('edit_tanggal_pengangkatan').value = tglPengangkatan;
    document.getElementById('edit_tmt_akhir').value = tmtAkhir;
    $('#modalEditJabatan').modal('show');
}

function hapusJabatan(action) {
    if (confirm('Yakin hapus data jabatan ini? Data tidak bisa dikembalikan.')) {
        document.getElementById('form-hapus-jabatan').action = action;
        document.getElementById('form-hapus-jabatan').submit();
    }
}

$(document).ready(function() {
    $('#tableJabatan').DataTable({
        responsive: true,
        autoWidth: false,
        language: { url: '//cdn.datatables.net/plug-ins/1.13.4/i18n/id.json' }
    });

    $('.select2-dosen').select2({
        theme: 'bootstrap4',
        dropdownParent: $('#modalTambahJabatan')
    });
});
</script>
@endsection