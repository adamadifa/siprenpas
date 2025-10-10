<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProgramUnggulan extends Model
{
    use HasFactory;

    protected $table = 'program_unggulan';

    protected $fillable = [
        'nama_program',
        'deskripsi',
        'urutan'
    ];

    protected $casts = [
        'urutan' => 'integer',
    ];
}
