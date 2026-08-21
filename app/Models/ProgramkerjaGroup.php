<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProgramkerjaGroup extends Model
{
    use HasFactory;
    protected $table = 'program_kerja_group';
    protected $primaryKey = 'kode_program_kerja_group';
    public $incrementing = false;
    protected $guarded = [];

    public function unit()
    {
        return $this->belongsTo(Unit::class, 'kode_unit', 'kode_unit');
    }

    public function departemen()
    {
        return $this->belongsTo(Departemen::class, 'kode_dept', 'kode_dept');
    }

    public function jabatan()
    {
        return $this->belongsTo(Jabatan::class, 'kode_jabatan', 'kode_jabatan');
    }

    public function tahunajaran()
    {
        return $this->belongsTo(Tahunajaran::class, 'kode_ta', 'kode_ta');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id');
    }

    public function details()
    {
        return $this->hasMany(Programkerja::class, 'kode_program_kerja_group', 'kode_program_kerja_group');
    }
}
