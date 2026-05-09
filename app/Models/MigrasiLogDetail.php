<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MigrasiLogDetail extends Model
{
    use HasFactory;

    protected $table = 'migrasi_log_detail';
    protected $fillable = [
        'migrasi_log_id',
        'no_pendaftaran',
        'id_siswa',
        'is_new_siswa',
        'baris_excel',
        'status',
        'keterangan'
    ];

    public function log()
    {
        return $this->belongsTo(MigrasiLog::class, 'migrasi_log_id');
    }

    public function pendaftaran()
    {
        return $this->belongsTo(Pendaftaran::class, 'no_pendaftaran', 'no_pendaftaran');
    }

    public function siswa()
    {
        return $this->belongsTo(Siswa::class, 'id_siswa', 'id_siswa');
    }
}
