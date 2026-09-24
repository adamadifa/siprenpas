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
        $user = auth()->user();
        if (!$user) {
            return Unit::whereNotIn('kode_unit', ['U00'])->orderBy('kode_unit')->get();
        }

        // Jika super admin, dapat mengakses semua unit operasional
        if ($user->hasRole('super admin')) {
            return Unit::whereNotIn('kode_unit', ['U00'])
                ->orderBy('kode_unit')
                ->get();
        }

        // Ambil unit yang diizinkan (unit utama + unit tambahan yang di-assign)
        $accessibleUnitCodes = $user->getAccessibleUnitCodes();

        return Unit::whereIn('kode_unit', $accessibleUnitCodes)
            ->whereNotIn('kode_unit', ['U00'])
            ->orderBy('kode_unit')
            ->get();
    }
}
