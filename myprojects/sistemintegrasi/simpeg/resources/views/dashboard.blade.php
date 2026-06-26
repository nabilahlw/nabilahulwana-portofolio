@extends('adminlte::page')

@section('title', 'Dashboard Integrasi')

@section('content_header')
    <h1>Dashboard Integrasi Korporasi</h1>
@endsection

@section('content')

{{-- Info dari halaman lama --}}
<div class="alert alert-info">
    <p>Selamat Datang di Halaman Sistem Informasi Akademik</p>
    <p>Anda login sebagai <b>Admin</b></p>
</div>

{{-- Info Box --}}
<div class="row">
    <div class="col-md-4">
        <x-adminlte-info-box title="Total Mahasiswa" text="1,200" icon="fas fa-lg fa-graduation-cap" theme="info"/>
    </div>
    <div class="col-md-4">
        <x-adminlte-info-box title="Total Pegawai" text="150" icon="fas fa-lg fa-users" theme="success"/>
    </div>
    <div class="col-md-4">
        <x-adminlte-info-box title="Tagihan Pending" text="Rp 50M" icon="fas fa-lg fa-wallet" theme="danger"/>
    </div>
</div>

{{-- Card Selamat Datang --}}
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Selamat Datang</h3>
    </div>
    <div class="card-body">
        Sistem Integrasi SIAKAD, SIKEU, dan SIMPEG siap dikembangkan.
    </div>
</div>

@endsection