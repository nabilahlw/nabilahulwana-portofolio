<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pegawai extends Model
{
    protected $connection = 'simpeg';
    protected $table = 'pegawai';
    public $timestamps = false;

    protected $fillable = [
        'nip', 'nama', 'jenis_pegawai', 'status_kepegawaian', 'unit_kerja'
    ];

    public function scopeDosen($query)
    {
        return $query->where('jenis_pegawai', 'Dosen');
    }

    // TAMBAHKAN RELASI INI:
    public function riwayatJabatan()
    {
        // Menghubungkan id pegawai ke kolom pegawai_id di tabel jabatan
        return $this->hasMany(Jabatan::class, 'pegawai_id', 'id');
    }
}