<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Jabatan extends Model
{
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

    public function pegawai()
    {
        return $this->belongsTo(Pegawai::class, 'pegawai_id');
    }
}