<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Unit extends Model
{
    use HasFactory;
    protected $table = "unit";
    protected $primaryKey = "kode_unit";
    protected $guarded = [];
    public $incrementing = false;

    public function getUnit()
    {
        $unit = Unit::whereNotIn('kode_unit', ['U00', 'U06'])
            ->orderBy('kode_unit')
            ->get();
        return $unit;
    }
}
