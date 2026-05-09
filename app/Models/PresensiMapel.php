<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PresensiMapel extends Model
{
    use HasFactory;

    protected $table = 'presensi_mapel';
    protected $fillable = [
        'jadwal_pelajaran_id',
        'kode_unit',
        'kode_kelas',
        'mata_pelajaran_id',
        'guru_id',
        'tanggal',
        'jam_mulai',
        'jam_selesai',
        'materi',
        'status_pertemuan'
    ];

    public function jadwal()
    {
        return $this->belongsTo(JadwalPelajaran::class, 'jadwal_pelajaran_id');
    }

    public function unit()
    {
        return $this->belongsTo(Unit::class, 'kode_unit', 'kode_unit');
    }

    public function kelas()
    {
        return $this->belongsTo(Kelas::class, 'kode_kelas', 'kode_kelas');
    }

    public function mata_pelajaran()
    {
        return $this->belongsTo(MataPelajaran::class, 'mata_pelajaran_id');
    }

    public function guru()
    {
        return $this->belongsTo(Guru::class, 'guru_id');
    }

    public function details()
    {
        return $this->hasMany(PresensiMapelDetail::class, 'presensi_mapel_id');
    }
}
