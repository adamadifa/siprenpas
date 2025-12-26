<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Province;
use App\Models\Regency;
use App\Models\District;
use App\Models\Village;
use Illuminate\Http\Request;

class RegionController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/public/regions/provinces",
     *     tags={"Regions"},
     *     summary="Daftar semua provinsi",
     *     description="Mengembalikan seluruh data provinsi di Indonesia",
     *     @OA\Response(
     *         response=200,
     *         description="Berhasil",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="string", example="success"),
     *             @OA\Property(property="count", type="integer", example=34),
     *             @OA\Property(
     *                 property="data",
     *                 type="array",
     *                 @OA\Items(
     *                     type="object",
     *                     @OA\Property(property="id", type="string", example="32"),
     *                     @OA\Property(property="name", type="string", example="Jawa Barat")
     *                 )
     *             )
     *         )
     *     )
     * )
     */
    public function getProvinces()
    {
        $provinces = Province::orderBy('name')->get(['id', 'name']);

        return response()->json([
            'status' => 'success',
            'count' => $provinces->count(),
            'data' => $provinces,
        ]);
    }

    /**
     * @OA\Get(
     *     path="/api/public/regions/regencies",
     *     tags={"Regions"},
     *     summary="Daftar kabupaten/kota berdasarkan provinsi",
     *     description="Mengembalikan data kabupaten/kota berdasarkan provinsi yang dipilih",
     *     @OA\Parameter(
     *         name="province_id",
     *         in="query",
     *         required=true,
     *         description="ID Provinsi",
     *         @OA\Schema(type="string", example="32")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Berhasil",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="string", example="success"),
     *             @OA\Property(property="count", type="integer", example=27),
     *             @OA\Property(
     *                 property="data",
     *                 type="array",
     *                 @OA\Items(
     *                     type="object",
     *                     @OA\Property(property="id", type="string", example="3201"),
     *                     @OA\Property(property="name", type="string", example="Bogor")
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Bad Request - Province ID tidak ditemukan atau tidak valid",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="string", example="error"),
     *             @OA\Property(property="message", type="string", example="The province id field is required.")
     *         )
     *     )
     * )
     */
    public function getRegencies(Request $request)
    {
        $request->validate([
            'province_id' => 'required|string',
        ]);

        $regencies = Regency::where('province_id', $request->province_id)
            ->orderBy('name')
            ->get(['id', 'name']);

        return response()->json([
            'status' => 'success',
            'count' => $regencies->count(),
            'data' => $regencies,
        ]);
    }

    /**
     * @OA\Get(
     *     path="/api/public/regions/districts",
     *     tags={"Regions"},
     *     summary="Daftar kecamatan berdasarkan kabupaten/kota",
     *     description="Mengembalikan data kecamatan berdasarkan kabupaten/kota yang dipilih",
     *     @OA\Parameter(
     *         name="regency_id",
     *         in="query",
     *         required=true,
     *         description="ID Kabupaten/Kota",
     *         @OA\Schema(type="string", example="3201")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Berhasil",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="string", example="success"),
     *             @OA\Property(property="count", type="integer", example=40),
     *             @OA\Property(
     *                 property="data",
     *                 type="array",
     *                 @OA\Items(
     *                     type="object",
     *                     @OA\Property(property="id", type="string", example="3201010"),
     *                     @OA\Property(property="name", type="string", example="Bogor Selatan")
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Bad Request - Regency ID tidak ditemukan atau tidak valid",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="string", example="error"),
     *             @OA\Property(property="message", type="string", example="The regency id field is required.")
     *         )
     *     )
     * )
     */
    public function getDistricts(Request $request)
    {
        $request->validate([
            'regency_id' => 'required|string',
        ]);

        $districts = District::where('regency_id', $request->regency_id)
            ->orderBy('name')
            ->get(['id', 'name']);

        return response()->json([
            'status' => 'success',
            'count' => $districts->count(),
            'data' => $districts,
        ]);
    }

    /**
     * @OA\Get(
     *     path="/api/public/regions/villages",
     *     tags={"Regions"},
     *     summary="Daftar kelurahan/desa berdasarkan kecamatan",
     *     description="Mengembalikan data kelurahan/desa berdasarkan kecamatan yang dipilih",
     *     @OA\Parameter(
     *         name="district_id",
     *         in="query",
     *         required=true,
     *         description="ID Kecamatan",
     *         @OA\Schema(type="string", example="3201010")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Berhasil",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="string", example="success"),
     *             @OA\Property(property="count", type="integer", example=15),
     *             @OA\Property(
     *                 property="data",
     *                 type="array",
     *                 @OA\Items(
     *                     type="object",
     *                     @OA\Property(property="id", type="string", example="3201010001"),
     *                     @OA\Property(property="name", type="string", example="Bojongkerta")
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Bad Request - District ID tidak ditemukan atau tidak valid",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="string", example="error"),
     *             @OA\Property(property="message", type="string", example="The district id field is required.")
     *         )
     *     )
     * )
     */
    public function getVillages(Request $request)
    {
        $request->validate([
            'district_id' => 'required|string',
        ]);

        $villages = Village::where('district_id', $request->district_id)
            ->orderBy('name')
            ->get(['id', 'name']);

        return response()->json([
            'status' => 'success',
            'count' => $villages->count(),
            'data' => $villages,
        ]);
    }
}

