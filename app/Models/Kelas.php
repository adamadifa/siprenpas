<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kelas extends Model
{
    use HasFactory;
    protected $table = 'kelas';
    protected $primaryKey = 'kode_kelas';
    protected $guarded = [];
    public $incrementing = false;

    public function unit()
    {
        return $this->belongsTo(Unit::class, 'kode_unit', 'kode_unit');
    }

    public function waliKelas()
    {
        return $this->belongsTo(Guru::class, 'guru_id');
    }

    public function siswa()
    {
        return $this->hasMany(Kelassiswa::class, 'kode_kelas', 'kode_kelas');
    }
}
