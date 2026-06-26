<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model 
{
    protected $connection = 'sikeu'; 
    protected $table = 'tagihan'; 

    // Gunakan fillable agar lebih konsisten dengan model Tagihan yang berhasil
    protected $fillable = [
        'nim', 'kategori', 'periode', 'total_tagihan', 
        'tanggal_jatuh_tempo', 'status_bayar', 'order_id', 'snap_token'
    ];

    public function mahasiswa()
    {
        return $this->belongsTo(Mahasiswa::class, 'nim', 'nim');
    }
}