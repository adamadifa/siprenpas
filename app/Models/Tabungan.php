<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tabungan extends Model
{
    use HasFactory;
    protected $table = 'koperasi_tabungan';
    protected $primaryKey = 'no_rekening';
    protected $guarded = [];
    public $incrementing = false;

    /**
     * Relasi ke model Anggota
     */
    public function anggota()
    {
        return $this->belongsTo(Anggota::class, 'no_anggota', 'no_anggota');
    }

    /**
     * Relasi ke model Jenistabungan
     */
    public function jenisTabungan()
    {
        return $this->belongsTo(Jenistabungan::class, 'kode_tabungan', 'kode_tabungan');
    }

    /**
     * Relasi ke model Siswa melalui siswa_anggota dan koperasi_anggota
     */
    public function siswa()
    {
        return $this->hasManyThrough(
            Siswa::class,
            SiswaAnggota::class,
            'no_anggota', // Foreign key on siswa_anggota table
            'id_siswa', // Foreign key on siswa table
            'no_anggota', // Local key on koperasi_tabungan table
            'id_siswa' // Local key on siswa_anggota table
        );
    }
}
