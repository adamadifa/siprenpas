<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SiswaAnggota extends Model
{
    use HasFactory;

    protected $table = 'siswa_anggota';

    protected $primaryKey = ['id_siswa', 'no_anggota'];

    public $incrementing = false;

    protected $fillable = [
        'id_siswa',
        'no_anggota'
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Relasi ke model Siswa
     */
    public function siswa()
    {
        return $this->belongsTo(Siswa::class, 'id_siswa', 'id_siswa');
    }

    /**
     * Relasi ke model Anggota
     */
    public function anggota()
    {
        return $this->belongsTo(Anggota::class, 'no_anggota', 'no_anggota');
    }
}
