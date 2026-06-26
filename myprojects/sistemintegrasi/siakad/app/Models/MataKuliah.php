<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MataKuliah extends Model
{
    protected $table = 'mata_kuliah';

    protected $fillable = [
        'kode_mk',
        'nama_mk',
        'sks',
        'semester',
        'dosen_pengampu_id',
    ];

    public function dosenPengampu()
    {
        return $this->belongsTo(Pegawai::class, 'dosen_pengampu_id', 'id');
    }
}