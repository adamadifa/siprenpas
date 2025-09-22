<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SebaranAlumni extends Model
{
    use HasFactory;

    protected $table = 'sebaran_alumni';

    protected $fillable = [
        'logo',
        'nama_universitas',
    ];
}
