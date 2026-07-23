<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @OA\Schema(
 *   schema="Unit",
 *   type="object",
 *   title="Unit",
 *   required={"kode_unit"},
 *   @OA\Property(property="kode_unit", type="string", description="Kode unit"),
 *   @OA\Property(property="nama_unit", type="string", description="Nama unit"),
 *   @OA\Property(property="logo", type="string", nullable=true, description="URL logo unit"),
 *   @OA\Property(property="status", type="integer", description="Status unit (1=Show, 0=Hide)"),
 *   @OA\Property(property="keterangan", type="string", nullable=true, description="Keterangan unit"),
 *   @OA\Property(property="created_at", type="string", format="date-time"),
 *   @OA\Property(property="updated_at", type="string", format="date-time")
 * )
 */
class Unit extends Model
{
    use HasFactory;
    protected $table = "unit";
    protected $primaryKey = "kode_unit";
    protected $guarded = [];
    public $incrementing = false;

    public function getUnit()
    {
        $user = User::where('id', auth()->user()->id)->first();
        if ($user->kode_unit == 'U06') {
            $unit = Unit::whereNotIn('kode_unit', ['U00', 'U06', 'U07'])
                ->orderBy('kode_unit')
                ->get();
        } else {
            $unit = Unit::where('kode_unit',$user->kode_unit)
                ->orderBy('kode_unit')
                ->get();
        }
        return $unit;
    }
}
