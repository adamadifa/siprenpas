<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Perlombaan extends Model
{
    use HasFactory;
    protected $table = "perlombaan";
    protected $guarded = [];

    public function jenjangPendidikan()
    {
        return $this->belongsTo(JenjangPendidikan::class, 'id_jenjang', 'id');
    }
}
