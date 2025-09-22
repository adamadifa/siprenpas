<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\SebaranAlumni;
use Illuminate\Http\Request;

class SebaranAlumniController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/public/sebaran-alumni",
     *     tags={"Sebaran Alumni (Public)"},
     *     summary="Daftar sebaran alumni (publik)",
     *     description="Mengembalikan seluruh data sebaran alumni berupa nama universitas dan URL logo.",
     *     @OA\Response(
     *         response=200,
     *         description="Berhasil",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="string", example="success"),
     *             @OA\Property(property="count", type="integer", example=3),
     *             @OA\Property(
     *                 property="data",
     *                 type="array",
     *                 @OA\Items(
     *                     type="object",
     *                     @OA\Property(property="id", type="integer", example=1),
     *                     @OA\Property(property="nama_universitas", type="string", example="Institut Teknologi Bandung"),
     *                     @OA\Property(property="logo", type="string", nullable=true, example="sebaran_alumni/itb.png"),
     *                     @OA\Property(property="logo_url", type="string", nullable=true, example="https://domain.test/storage/sebaran_alumni/itb.png"),
     *                     @OA\Property(property="created_at", type="string", format="date-time", example="2025-09-22T12:34:56Z"),
     *                     @OA\Property(property="updated_at", type="string", format="date-time", example="2025-09-22T12:34:56Z")
     *                 )
     *             )
     *         )
     *     )
     * )
     * Handle the incoming request.
     */
    public function index(Request $request)
    {
        $items = SebaranAlumni::orderBy('nama_universitas')
            ->get(['id', 'nama_universitas', 'logo', 'created_at', 'updated_at']);

        $data = $items->map(function ($item) {
            return [
                'id' => $item->id,
                'nama_universitas' => $item->nama_universitas,
                'logo' => $item->logo,
                'logo_url' => $item->logo ? asset('storage/' . $item->logo) : null,
                'created_at' => $item->created_at,
                'updated_at' => $item->updated_at,
            ];
        });

        return response()->json([
            'status' => 'success',
            'count' => $data->count(),
            'data' => $data,
        ]);
    }
}
