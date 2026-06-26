<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Mahasiswa extends Model
{
    protected $connection = 'mysql';   // <-- tambahkan baris ini
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
    public function dosenWali()
    {
        return $this->belongsTo(Pegawai::class, 'dosen_wali_id', 'id');
    }
}