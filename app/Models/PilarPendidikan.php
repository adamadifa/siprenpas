<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PilarPendidikan extends Model
{
    use HasFactory;

    protected $table = 'pilar_pendidikan';

    protected $fillable = [
        'nama_pilar',
        'deskripsi',
        'urutan',
    ];
}

