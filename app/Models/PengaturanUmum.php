<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PengaturanUmum extends Model
{
    use HasFactory;

    protected $table = 'pengaturan_umum';

    protected $fillable = [
        'logo',
        'background_login',
        'model_1',
        'model_2',
        'model_3',
        'model_4',
        'nama_aplikasi',
        'nama_sekolah',
        'alamat_sekolah',
        'telepon',
        'email',
        'website',
        'facebook',
        'youtube',
        'instagram',
        'tiktok',
        'session_lifetime',
        'brosur_utama'
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];
}
