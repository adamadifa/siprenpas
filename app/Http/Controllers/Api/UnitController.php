<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

/**
 * @OA\Info(
 *     title="SiprenPAS API",
 *     version="1.0.0"
 * )
 *
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
            ->get();
        return response()->json($units);
    }
}
