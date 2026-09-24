<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Departemen extends Model
{
    use HasFactory;
    protected $table = 'departemen';
    protected $primaryKey = 'kode_dept';
    public $incrementing = false;
    protected $guarded = [];

    /**
     * Mendapatkan daftar departemen yang boleh diakses user saat ini.
     * Mengikuti prinsip yang sama dengan getUnit().
     */
    public function getDepartemen()
    {
        $user = auth()->user();
        if (!$user) {
            return self::orderBy('kode_dept')->get();
        }

        if ($user->hasRole('super admin')) {
            return self::orderBy('kode_dept')->get();
        }

        $accessibleDepts = $user->getAccessibleDeptCodes();

        return self::whereIn('kode_dept', $accessibleDepts)
            ->orderBy('kode_dept')
            ->get();
    }
}
