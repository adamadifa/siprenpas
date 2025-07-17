<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tahunajaranppdb extends Model
{
    use HasFactory;
    protected $table = 'konfigurasi_tahunajaran_ppdb';
    protected $guarded = [];
    protected $primaryKey = 'kode_ta_ppdb';
    public $incrementing = false;
    protected $keyType = 'string';
}
