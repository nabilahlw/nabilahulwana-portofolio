<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tagihan extends Model
{
    // Tambahkan 2 baris ini di bagian paling atas isi kelas model
    protected $connection = 'sikeu';
    protected $table = 'tagihan';

    protected $fillable = [
        'nim', 'kategori', 'periode', 'total_tagihan', 
        'tanggal_jatuh_tempo', 'status_bayar', 'order_id', 'snap_token'
    ];

    // Jika Anda memiliki relasi mahasiswa, pastikan seperti ini
    public function mahasiswa()
    {
        return $this->belongsTo(Mahasiswa::class, 'nim', 'nim');
    }
}