<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PendaftaranLomba extends Model
{
    use HasFactory;
    protected $table = "pendaftaran_lomba";
    protected $guarded = [];

    public function pendaftaranGotTalent()
    {
        return $this->belongsTo(PendaftaranGotTalent::class, 'id_pendaftaran', 'id');
    }

    public function perlombaan()
    {
        return $this->belongsTo(Perlombaan::class, 'id_perlombaan', 'id');
    }
}
