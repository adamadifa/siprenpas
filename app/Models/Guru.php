<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Guru extends Model
{
    use HasFactory;
    protected $table = 'guru';
    protected $guarded = [];
    protected $appends = ['nama_guru'];

    public function getNamaGuruAttribute()
    {
        return $this->karyawan ? $this->karyawan->nama_lengkap : '-';
    }

    public function karyawan()
    {
        return $this->belongsTo(Karyawan::class, 'npp', 'npp');
    }

    public function unit()
    {
        return $this->belongsTo(Unit::class, 'kode_unit', 'kode_unit');
    }

    public function jabatanAkademik()
    {
        return $this->belongsTo(JabatanAkademik::class, 'kode_jabatan', 'kode_jabatan');
    }
}
