<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PendaftaranGotTalent extends Model
{
    use HasFactory;
    protected $table = "pendaftaran_got_talent";
    protected $guarded = [];

    public function jenjangPendidikan()
    {
        return $this->belongsTo(JenjangPendidikan::class, 'id_jenjang', 'id');
    }

    public function perlombaan()
    {
        return $this->belongsToMany(Perlombaan::class, 'pendaftaran_lomba', 'id_pendaftaran', 'id_perlombaan');
    }
}
