<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Programkerja extends Model
{
    use HasFactory;
    protected $table = 'program_kerja';
    protected $primaryKey = 'kode_program_kerja';
    public $incrementing = false;
    protected $guarded = [];

    public function group()
    {
        return $this->belongsTo(ProgramkerjaGroup::class, 'kode_program_kerja_group', 'kode_program_kerja_group');
    }
}
