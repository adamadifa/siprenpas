<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Userpendaftar extends Model
{
    use HasFactory;
    protected $table = 'user_pendaftar';
    protected $fillable = [
        'no_register',
        'id_user',
    ];
}
