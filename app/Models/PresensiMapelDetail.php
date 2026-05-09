<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PresensiMapelDetail extends Model
{
    use HasFactory;

    protected $table = 'presensi_mapel_detail';
    protected $fillable = [
        'presensi_mapel_id',
        'siswa_id',
        'status',
        'keterangan'
    ];

    public function presensi()
    {
        return $this->belongsTo(PresensiMapel::class, 'presensi_mapel_id');
    }

    public function siswa()
    {
        return $this->belongsTo(Siswa::class, 'siswa_id', 'id_siswa');
    }
}
