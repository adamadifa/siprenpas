<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UnitLandingSetting extends Model
{
    use HasFactory;

    protected $table = 'unit_landing_settings';
    protected $primaryKey = 'kode_unit';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $guarded = [];

    protected $casts = [
        'custom_programs' => 'array',
        'custom_fasilitas' => 'array',
        'custom_testimoni' => 'array',
    ];

    public function unit()
    {
        return $this->belongsTo(Unit::class, 'kode_unit', 'kode_unit');
    }
}
