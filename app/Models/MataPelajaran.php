<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MataPelajaran extends Model
{
    use HasFactory;

    protected $table = 'mata_pelajaran';

    protected $fillable = [
        'kode_unit',
        'kode_matpel',
        'nama_matpel',
        'kelompok',
        'parent_id',
        'urutan',
        'aktif'
    ];

    /**
     * Relasi ke Unit.
     */
    public function unit()
    {
        return $this->belongsTo(Unit::class, 'kode_unit', 'kode_unit');
    }

    /**
     * Relasi ke Parent (Mata Pelajaran Induk).
     */
    public function parent()
    {
        return $this->belongsTo(MataPelajaran::class, 'parent_id');
    }

    /**
     * Relasi ke Children (Sub Mata Pelajaran).
     * Diurutkan berdasarkan kolom 'urutan'.
     */
    public function children()
    {
        return $this->hasMany(MataPelajaran::class, 'parent_id')->orderBy('urutan');
    }

    /**
     * Scope untuk mengambil mapel root (tanpa parent).
     */
    public function scopeRoot($query)
    {
        return $query->whereNull('parent_id');
    }

    /**
     * Scope untuk mengambil mapel yang aktif saja.
     */
    public function scopeActive($query)
    {
        return $query->where('aktif', true);
    }
}
