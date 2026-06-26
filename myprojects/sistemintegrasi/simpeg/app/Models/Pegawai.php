<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pegawai extends Model
{
    protected $connection = 'simpeg';
    protected $table = 'pegawai';
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $fillable = [
        'nip',
        'nama',
        'jenis_pegawai',
        'status_kepegawaian',
        'unit_kerja'
    ];

    public function jabatan()
    {
        return $this->hasMany(Jabatan::class, 'pegawai_id');
    }

    // Dipakai di JabatanController untuk filter dropdown: hanya dosen
    public function scopeDosen($query)
    {
        return $query->where('jenis_pegawai', 'Dosen');
    }
}