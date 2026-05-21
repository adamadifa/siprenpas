<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JadwalPelajaran extends Model
{
    use HasFactory;

    protected $table = 'jadwal_pelajaran';
    protected $guarded = ['id'];

    public function unit()
    {
        return $this->belongsTo(Unit::class, 'kode_unit', 'kode_unit');
    }

    public function tahunAjaran()
    {
        return $this->belongsTo(Tahunajaran::class, 'kode_ta', 'kode_ta');
    }

    public function kelas()
    {
        return $this->belongsTo(Kelas::class, 'kode_kelas', 'kode_kelas');
    }

    public function mapel()
    {
        return $this->belongsTo(MataPelajaran::class, 'mata_pelajaran_id');
    }

    public function guru()
    {
        return $this->belongsTo(Guru::class, 'guru_id');
    }

    public function presensi()
    {
        return $this->hasMany(PresensiMapel::class, 'jadwal_pelajaran_id');
    }
}
