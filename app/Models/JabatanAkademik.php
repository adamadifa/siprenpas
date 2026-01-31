<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JabatanAkademik extends Model
{
    use HasFactory;
    protected $table = 'jabatan_akademik';
    protected $primaryKey = 'kode_jabatan';
    protected $guarded = [];
    public $incrementing = false;
}
