<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Mahasiswa extends Model
{
    protected $connection = 'siakad';
    protected $table = 'mahasiswa';
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $fillable = [
        'nim',
        'nama',
        'id_prodi',
        'status_aktif',
        'dosen_wali_id',
    ];
    public function tagihan()
    {
        // Parameter ke-2: foreign key di tabel tagihan ('nim')
        // Parameter ke-3: local key di tabel mahasiswa ('nim')
        return $this->hasMany(Tagihan::class, 'nim', 'nim');
    }
}