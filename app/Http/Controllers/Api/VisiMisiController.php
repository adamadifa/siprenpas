<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Misi;
use App\Models\Visi;
use Illuminate\Http\Request;

class VisiMisiController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/public/visi-misi",
     *     tags={"Visi & Misi (Public)"},
     *     summary="Data visi dan misi (publik)",
     *     description="Mengembalikan data visi (single) dan daftar misi (multiple) dalam satu response.",
     *     @OA\Response(
     *         response=200,
     *         description="Berhasil",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="string", example="success"),
     *             @OA\Property(
     *                 property="visi",
     *                 type="object",
     *                 nullable=true,
     *                 @OA\Property(property="id", type="integer", example=1),
     *                 @OA\Property(property="deskripsi", type="string", example="Menjadi lembaga pendidikan terdepan yang mencetak kader muslim berkualitas"),
     *                 @OA\Property(property="created_at", type="string", format="date-time", example="2025-09-22T12:34:56Z"),
     *                 @OA\Property(property="updated_at", type="string", format="date-time", example="2025-09-22T12:34:56Z")
     *             ),
     *             @OA\Property(
     *                 property="misi",
     *                 type="array",
     *                 @OA\Items(
     *                     type="object",
     *                     @OA\Property(property="id", type="integer", example=1),
     *                     @OA\Property(property="judul", type="string", nullable=true, example="Pencetak Kader Muslim 5M"),
     *                     @OA\Property(property="deskripsi", type="string", example="Menjadi lembaga pencetak kader muslim dengan predikat 5M"),
     *                     @OA\Property(property="created_at", type="string", format="date-time", example="2025-09-22T12:34:56Z"),
     *                     @OA\Property(property="updated_at", type="string", format="date-time", example="2025-09-22T12:34:56Z")
     *                 )
     *             ),
     *             @OA\Property(property="misi_count", type="integer", example=6)
     *         )
     *     )
     * )
     */
    public function index()
    {
        $visi = Visi::first();
        $misi = Misi::orderBy('id')->get();

        return response()->json([
            'status' => 'success',
            'visi' => $visi,
            'misi' => $misi,
            'misi_count' => $misi->count(),
        ]);
    }
}
