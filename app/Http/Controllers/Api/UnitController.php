<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

/**
 * @OA\Tag(
 *     name="Unit",
 *     description="Manajemen Unit"
 * )
 */
class UnitController extends Controller
{
    /**
     * @OA\Get(
     *     path="/unit",
     *     tags={"Unit"},
     *     summary="Ambil daftar unit",
     *     security={{"sanctum":{}}},
     *     @OA\Response(
     *         response=200,
     *         description="Berhasil ambil daftar unit",
     *         @OA\JsonContent(type="array", @OA\Items(ref="#/components/schemas/Unit"))
     *     )
     * )
     */
    public function index()
    {
        $units = \App\Models\Unit::whereNotIn('kode_unit', ['U00', 'U06'])
            ->orderBy('kode_unit')
            ->get()
            ->map(function ($unit) {
                $data = $unit->toArray();
                
                // Format URL untuk logo jika ada
                if (!empty($data['logo'])) {
                    $data['logo'] = asset('storage/' . $data['logo']);
                }
                
                return $data;
            });
        return response()->json($units);
    }
}
