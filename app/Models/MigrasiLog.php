<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MigrasiLog extends Model
{
    use HasFactory;

    protected $table = 'migrasi_log';
    protected $fillable = [
        'nama_file',
        'kode_ta',
        'total_baris',
        'berhasil',
        'gagal',
        'status',
        'catatan_error',
        'id_user'
    ];

    protected $casts = [
        'catatan_error' => 'array'
    ];

    public function details()
    {
        return $this->hasMany(MigrasiLogDetail::class, 'migrasi_log_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }

    public function tahunAjaran()
    {
        return $this->belongsTo(Tahunajaran::class, 'kode_ta', 'kode_ta');
    }
}
