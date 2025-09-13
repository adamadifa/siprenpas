<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Siswa extends Model
{
    use HasFactory;
    protected $table = "siswa";
    protected $primaryKey = "id_siswa";
    protected $guarded = [];

    public function getSiswa($id_siswa = null)
    {
        $query = Siswa::query();
        if (!empty($id_siswa)) {
            $query->where('id_siswa', $id_siswa);
        }
        return $query;
    }

    /**
     * Relasi many-to-many ke anggota koperasi melalui tabel pivot siswa_anggota
     */
    public function anggotaKoperasi()
    {
        return $this->belongsToMany(Anggota::class, 'siswa_anggota', 'id_siswa', 'no_anggota');
    }

    /**
     * Relasi ke tabel pivot siswa_anggota
     */
    public function siswaAnggota()
    {
        return $this->hasMany(SiswaAnggota::class, 'id_siswa', 'id_siswa');
    }
}
