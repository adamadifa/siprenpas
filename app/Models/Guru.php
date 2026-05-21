<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Guru extends Authenticatable
{
    use HasFactory, Notifiable;
    protected $table = 'guru';
    protected $guarded = [];
    protected $appends = ['nama_guru'];
    protected $hidden = ['password', 'remember_token'];

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
