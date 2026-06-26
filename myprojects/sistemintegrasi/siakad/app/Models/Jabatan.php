<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Jabatan extends Model
{
    // Menghubungkan model ini ke database & tabel milik SIMPEG
    protected $connection = 'simpeg';
    protected $table = 'jabatan';

    protected $fillable = [
        'pegawai_id',
        'nama_jabatan',
        'tanggal_pengangkatan',
        'tmt_akhir',
    ];

    protected $casts = [
        'tanggal_pengangkatan' => 'date',
        'tmt_akhir' => 'date',
    ];
}