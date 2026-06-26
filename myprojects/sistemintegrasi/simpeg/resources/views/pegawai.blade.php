@extends('adminlte::page')

@section('title', 'Data Pegawai')

@section('content_header')
    <h1>Manajemen Pegawai / Dosen (SIMPEG)</h1>
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
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Daftar Pegawai</h3>
        <div class="card-tools">
            <a href="#" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#modalTambah">
                <i class="fas fa-plus"></i> Tambah Data
            </a>
        </div>
    </div>

    @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card-body">
        <table class="table table-bordered" id="tablePegawai">
            <thead>
                <tr>
                    <th>NIP</th>
                    <th>Nama</th>
                    <th>Unit Kerja</th>
                    <th>Jenis Pegawai</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($data as $item)
                <tr>
                    <td>{{ $item->nip }}</td>
                    <td>{{ $item->nama }}</td>
                    <td>
                        @if($item->unit_kerja == 1) Sistem Informasi
                        @elseif($item->unit_kerja == 2) Teknik Informatika
                        @elseif($item->unit_kerja == 3) Teknik Komputer
                        @else -
                        @endif
                    </td>
                    <td>{{ $item->jenis_pegawai }}</td>
                    <td>
                        @if($item->status_kepegawaian == 'Tetap')
                            <span class="badge badge-success">Tetap</span>
                        @else
                            <span class="badge badge-danger">Kontrak</span>
                        @endif
                    </td>
                    <td>
                        <nobr>
                            <button class="btn btn-xs btn-default text-primary mx-1 shadow btn-edit" data-id="{{ $item->id }}">
                                <i class="fa fa-pen"></i>
                            </button>
                            <form action="{{ url('/pegawai/hapus/'.$item->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Yakin hapus data ini?')">
                                @csrf
                                <button type="submit" class="btn btn-xs btn-default text-danger mx-1 shadow">
                                    <i class="fa fa-trash"></i>
                                </button>
                            </form>
                        </nobr>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

{{-- Modal Tambah --}}
<div class="modal fade" id="modalTambah">
    <div class="modal-dialog">
        <form action="/pegawai/simpan" method="POST">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5>Tambah Pegawai</h5>
                    <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>NIP</label>
                        <input type="text" name="nip" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Nama</label>
                        <input type="text" name="nama" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Unit Kerja</label>
                        <select name="unit_kerja" class="form-control" required>
                            <option value="1">Sistem Informasi</option>
                            <option value="2">Teknik Informatika</option>
                            <option value="3">Teknik Komputer</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Jenis Pegawai</label>
                        <select name="jenis_pegawai" class="form-control" required>
                            <option value="Dosen">Dosen</option>
                            <option value="Tenaga Kependidikan">Tenaga Kependidikan</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Status Kepegawaian</label>
                        <select name="status_kepegawaian" class="form-control" required>
                            <option value="Tetap">Tetap</option>
                            <option value="Kontrak">Kontrak</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-success">Simpan</button>
                </div>
            </div>
        </form>
    </div>
</div>

{{-- Modal Edit --}}
<div class="modal fade" id="modalEdit">
    <div class="modal-dialog">
        <form id="formEdit">
            @csrf
            <input type="hidden" id="edit_id">
            <div class="modal-content">
                <div class="modal-header">
                    <h5>Edit Pegawai</h5>
                    <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>NIP</label>
                        <input type="text" id="edit_nip" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>Nama</label>
                        <input type="text" id="edit_nama" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>Unit Kerja</label>
                        <select id="edit_unit_kerja" class="form-control">
                            <option value="1">Sistem Informasi</option>
                            <option value="2">Teknik Informatika</option>
                            <option value="3">Teknik Komputer</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Jenis Pegawai</label>
                        <select id="edit_jenis_pegawai" class="form-control">
                            <option value="Dosen">Dosen</option>
                            <option value="Tenaga Kependidikan">Tenaga Kependidikan</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Status Kepegawaian</label>
                        <select id="edit_status_kepegawaian" class="form-control">
                            <option value="Tetap">Tetap</option>
                            <option value="Kontrak">Kontrak</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-success">Update</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection

@section('js')
<script>
$(document).ready(function() {
    $('#tablePegawai').DataTable({
        responsive: true,
        autoWidth: false,
        language: { url: '//cdn.datatables.net/plug-ins/1.13.4/i18n/id.json' }
    });

    $(document).on('click', '.btn-edit', function() {
        let id = $(this).data('id');
        $.get('/pegawai/' + id, function(data) {
            $('#edit_id').val(data.id);
            $('#edit_nip').val(data.nip);
            $('#edit_nama').val(data.nama);
            $('#edit_unit_kerja').val(data.unit_kerja);
            $('#edit_jenis_pegawai').val(data.jenis_pegawai);
            $('#edit_status_kepegawaian').val(data.status_kepegawaian);
            $('#modalEdit').modal('show');
        });
    });

    $(document).on('submit', '#formEdit', function(e) {
        e.preventDefault();
        let id = $('#edit_id').val();
        $.post('/pegawai/' + id, {
            _token: '{{ csrf_token() }}',
            nip: $('#edit_nip').val(),
            nama: $('#edit_nama').val(),
            unit_kerja: $('#edit_unit_kerja').val(),
            jenis_pegawai: $('#edit_jenis_pegawai').val(),
            status_kepegawaian: $('#edit_status_kepegawaian').val()
        }, function() {
            $('#modalEdit').modal('hide');
            location.reload();
        }).fail(function(xhr) {
            alert('Gagal update: ' + (xhr.responseJSON?.message || 'cek input'));
        });
    });
});
</script>
@endsection