<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RencanaPenilaian extends Model
{
    use HasFactory;

    protected $table = 'rencana_penilaian';
    protected $guarded = [];

    public function bobotPenilaian()
    {
        return $this->belongsTo(BobotPenilaian::class, 'bobot_penilaian_id');
    }

    public function nilaiSiswa()
    {
        return $this->hasMany(NilaiSiswa::class, 'rencana_penilaian_id');
    }
}
