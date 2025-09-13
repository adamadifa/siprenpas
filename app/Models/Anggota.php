<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Anggota extends Model
{
    use HasFactory;
    protected $table = 'koperasi_anggota';
    protected $guarded = [];
    protected $primaryKey = 'no_anggota';
    public $incrementing = false;

    /**
     * Relasi many-to-many ke siswa melalui tabel pivot siswa_anggota
     */
    public function siswa()
    {
        return $this->belongsToMany(Siswa::class, 'siswa_anggota', 'no_anggota', 'id_siswa');
    }

    /**
     * Relasi ke tabel pivot siswa_anggota
     */
    public function siswaAnggota()
    {
        return $this->hasMany(SiswaAnggota::class, 'no_anggota', 'no_anggota');
    }
}
