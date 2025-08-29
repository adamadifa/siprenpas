<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\PrestasiSiswa;
use Illuminate\Http\Request;

/**
 * @OA\Tag(
 *     name="Prestasi Siswa",
 *     description="API Endpoints untuk data prestasi siswa"
 * )
 */
class PrestasiSiswaController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/public/prestasi-siswa",
     *     summary="Mendapatkan daftar prestasi siswa",
     *     description="Mengambil semua data prestasi siswa yang aktif",
     *     tags={"Prestasi Siswa"},
     *     @OA\Parameter(
     *         name="limit",
     *         in="query",
     *         description="Jumlah data yang akan ditampilkan (default: 10)",
     *         required=false,
     *         @OA\Schema(type="integer", default=10)
     *     ),
     *     @OA\Parameter(
     *         name="tingkat",
     *         in="query",
     *         description="Filter berdasarkan tingkat prestasi (kecamatan, kabupaten, nasional)",
     *         required=false,
     *         @OA\Schema(type="string", enum={"kecamatan", "kabupaten", "nasional"})
     *     ),
     *     @OA\Parameter(
     *         name="unit",
     *         in="query",
     *         description="Filter berdasarkan kode unit",
     *         required=false,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Berhasil mengambil data prestasi siswa",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="Data prestasi siswa berhasil diambil"),
     *             @OA\Property(property="data", type="array", @OA\Items(
     *                 @OA\Property(property="id", type="integer", example=1),
     *                 @OA\Property(property="nama_siswa", type="string", example="Ahmad Fadli"),
     *                 @OA\Property(property="prestasi", type="string", example="Juara 1 Lomba Matematika"),
     *                 @OA\Property(property="tingkat", type="string", example="kecamatan"),
     *                 @OA\Property(property="foto", type="string", example="prestasi_1.jpg"),
     *                 @OA\Property(property="foto_url", type="string", example="http://localhost:8000/storage/prestasi-siswa/prestasi_1.jpg"),
     *                 @OA\Property(property="unit", type="object", nullable=true,
     *                     @OA\Property(property="kode_unit", type="string", example="001"),
     *                     @OA\Property(property="nama_unit", type="string", example="SD Al Amin 1")
     *                 ),
     *                 @OA\Property(property="created_at", type="string", format="date-time"),
     *                 @OA\Property(property="updated_at", type="string", format="date-time")
     *             ))
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Server error",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=false),
     *             @OA\Property(property="message", type="string", example="Terjadi kesalahan server")
     *         )
     *     )
     * )
     */
    public function index(Request $request)
    {
        try {
            $query = PrestasiSiswa::with(['unit'])
                ->where('status', 1)
                ->orderBy('created_at', 'desc');

            // Filter berdasarkan tingkat
            if ($request->has('tingkat') && in_array($request->tingkat, ['kecamatan', 'kabupaten', 'nasional'])) {
                $query->where('tingkat', $request->tingkat);
            }

            // Filter berdasarkan unit
            if ($request->has('unit') && !empty($request->unit)) {
                $query->where('kode_unit', $request->unit);
            }

            // Limit data
            $limit = $request->get('limit', 10);
            $prestasiSiswa = $query->limit($limit)->get();

            // Tambahkan foto_url
            $prestasiSiswa->each(function ($item) {
                if ($item->foto) {
                    $item->foto_url = asset('storage/prestasi-siswa/' . $item->foto);
                } else {
                    $item->foto_url = null;
                }
            });

            return response()->json([
                'success' => true,
                'message' => 'Data prestasi siswa berhasil diambil',
                'data' => $prestasiSiswa
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan server: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * @OA\Get(
     *     path="/api/public/prestasi-siswa/{id}",
     *     summary="Mendapatkan detail prestasi siswa",
     *     description="Mengambil detail prestasi siswa berdasarkan ID",
     *     tags={"Prestasi Siswa"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID prestasi siswa",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Berhasil mengambil detail prestasi siswa",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="Detail prestasi siswa berhasil diambil"),
     *             @OA\Property(property="data", type="object",
     *                 @OA\Property(property="id", type="integer", example=1),
     *                 @OA\Property(property="nama_siswa", type="string", example="Ahmad Fadli"),
     *                 @OA\Property(property="prestasi", type="string", example="Juara 1 Lomba Matematika"),
     *                 @OA\Property(property="tingkat", type="string", example="kecamatan"),
     *                 @OA\Property(property="foto", type="string", example="prestasi_1.jpg"),
     *                 @OA\Property(property="foto_url", type="string", example="http://localhost:8000/storage/prestasi-siswa/prestasi_1.jpg"),
     *                 @OA\Property(property="unit", type="object", nullable=true,
     *                     @OA\Property(property="kode_unit", type="string", example="001"),
     *                     @OA\Property(property="nama_unit", type="string", example="SD Al Amin 1")
     *                 ),
     *                 @OA\Property(property="created_at", type="string", format="date-time"),
     *                 @OA\Property(property="updated_at", type="string", format="date-time")
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Prestasi siswa tidak ditemukan",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=false),
     *             @OA\Property(property="message", type="string", example="Prestasi siswa tidak ditemukan")
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Server error",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=false),
     *             @OA\Property(property="message", type="string", example="Terjadi kesalahan server")
     *         )
     *     )
     * )
     */
    public function show($id)
    {
        try {
            $prestasiSiswa = PrestasiSiswa::with(['unit'])
                ->where('status', 1)
                ->find($id);

            if (!$prestasiSiswa) {
                return response()->json([
                    'success' => false,
                    'message' => 'Prestasi siswa tidak ditemukan'
                ], 404);
            }

            // Tambahkan foto_url
            if ($prestasiSiswa->foto) {
                $prestasiSiswa->foto_url = asset('storage/prestasi-siswa/' . $prestasiSiswa->foto);
            } else {
                $prestasiSiswa->foto_url = null;
            }

            return response()->json([
                'success' => true,
                'message' => 'Detail prestasi siswa berhasil diambil',
                'data' => $prestasiSiswa
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan server: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * @OA\Get(
     *     path="/api/public/prestasi-siswa/random/{limit}",
     *     summary="Mendapatkan prestasi siswa secara acak",
     *     description="Mengambil data prestasi siswa secara acak dengan limit tertentu",
     *     tags={"Prestasi Siswa"},
     *     @OA\Parameter(
     *         name="limit",
     *         in="path",
     *         description="Jumlah data yang akan ditampilkan (default: 3)",
     *         required=false,
     *         @OA\Schema(type="integer", default=3)
     *     ),
     *     @OA\Parameter(
     *         name="tingkat",
     *         in="query",
     *         description="Filter berdasarkan tingkat prestasi (kecamatan, kabupaten, nasional)",
     *         required=false,
     *         @OA\Schema(type="string", enum={"kecamatan", "kabupaten", "nasional"})
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Berhasil mengambil data prestasi siswa secara acak",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="Data prestasi siswa acak berhasil diambil"),
     *             @OA\Property(property="data", type="array", @OA\Items(
     *                 @OA\Property(property="id", type="integer", example=1),
     *                 @OA\Property(property="nama_siswa", type="string", example="Ahmad Fadli"),
     *                 @OA\Property(property="prestasi", type="string", example="Juara 1 Lomba Matematika"),
     *                 @OA\Property(property="tingkat", type="string", example="kecamatan"),
     *                 @OA\Property(property="foto", type="string", example="prestasi_1.jpg"),
     *                 @OA\Property(property="foto_url", type="string", example="http://localhost:8000/storage/prestasi-siswa/prestasi_1.jpg"),
     *                 @OA\Property(property="unit", type="object", nullable=true,
     *                     @OA\Property(property="kode_unit", type="string", example="001"),
     *                     @OA\Property(property="nama_unit", type="string", example="SD Al Amin 1")
     *                 )
     *             ))
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Server error",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=false),
     *             @OA\Property(property="message", type="string", example="Terjadi kesalahan server")
     *         )
     *     )
     * )
     */
    public function random(Request $request, $limit = 3)
    {
        try {
            $query = PrestasiSiswa::with(['unit'])
                ->where('status', 1);

            // Filter berdasarkan tingkat
            if ($request->has('tingkat') && in_array($request->tingkat, ['kecamatan', 'kabupaten', 'nasional'])) {
                $query->where('tingkat', $request->tingkat);
            }

            $prestasiSiswa = $query->inRandomOrder()
                ->limit($limit)
                ->get();

            // Tambahkan foto_url
            $prestasiSiswa->each(function ($item) {
                if ($item->foto) {
                    $item->foto_url = asset('storage/prestasi-siswa/' . $item->foto);
                } else {
                    $item->foto_url = null;
                }
            });

            return response()->json([
                'success' => true,
                'message' => 'Data prestasi siswa acak berhasil diambil',
                'data' => $prestasiSiswa
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan server: ' . $e->getMessage()
            ], 500);
        }
    }
}
