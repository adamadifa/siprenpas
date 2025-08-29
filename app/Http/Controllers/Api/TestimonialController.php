<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Testimonial;
use Illuminate\Http\Request;

/**
 * @OA\Tag(
 *     name="Testimonials",
 *     description="API Endpoints untuk Testimoni"
 * )
 */
class TestimonialController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/public/testimonials",
     *     summary="Mendapatkan daftar testimoni aktif",
     *     description="Mengambil semua testimoni yang berstatus aktif untuk ditampilkan di website",
     *     tags={"Testimonials"},
     *     @OA\Response(
     *         response=200,
     *         description="Berhasil mendapatkan data testimoni",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="Data testimoni berhasil diambil"),
     *             @OA\Property(
     *                 property="data",
     *                 type="array",
     *                 @OA\Items(
     *                     @OA\Property(property="id", type="integer", example=1),
     *                     @OA\Property(property="nama", type="string", example="Ahmad Rizki"),
     *                     @OA\Property(property="testimoni", type="string", example="Sekolah Al-Amin telah memberikan pendidikan yang berkualitas tinggi..."),
     *                     @OA\Property(property="foto", type="string", nullable=true, example="1234567890_foto.jpg"),
     *                     @OA\Property(property="foto_url", type="string", nullable=true, example="http://localhost:8000/storage/testimonials/1234567890_foto.jpg"),
     *                     @OA\Property(property="status", type="boolean", example=true),
     *                     @OA\Property(property="created_at", type="string", format="date-time", example="2025-08-29T08:45:43.000000Z"),
     *                     @OA\Property(property="updated_at", type="string", format="date-time", example="2025-08-29T08:45:43.000000Z")
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Error server",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="boolean", example=false),
     *             @OA\Property(property="message", type="string", example="Terjadi kesalahan pada server"),
     *             @OA\Property(property="data", type="null", example=null)
     *         )
     *     )
     * )
     */
    public function index()
    {
        try {
            $testimonials = Testimonial::where('status', 1)
                ->orderBy('created_at', 'desc')
                ->get()
                ->map(function ($testimonial) {
                    return [
                        'id' => $testimonial->id,
                        'nama' => $testimonial->nama,
                        'testimoni' => $testimonial->testimoni,
                        'foto' => $testimonial->foto,
                        'foto_url' => $testimonial->foto ? asset('storage/testimonials/' . $testimonial->foto) : null,
                        'status' => (bool) $testimonial->status,
                        'created_at' => $testimonial->created_at,
                        'updated_at' => $testimonial->updated_at,
                    ];
                });

            return response()->json([
                'status' => true,
                'message' => 'Data testimoni berhasil diambil',
                'data' => $testimonials
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Terjadi kesalahan pada server',
                'data' => null
            ], 500);
        }
    }

    /**
     * @OA\Get(
     *     path="/api/public/testimonials/{id}",
     *     summary="Mendapatkan detail testimoni berdasarkan ID",
     *     description="Mengambil detail testimoni tertentu berdasarkan ID yang diberikan",
     *     tags={"Testimonials"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID testimoni",
     *         required=true,
     *         @OA\Schema(type="integer", example=1)
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Berhasil mendapatkan detail testimoni",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="Detail testimoni berhasil diambil"),
     *             @OA\Property(
     *                 property="data",
     *                 type="object",
     *                 @OA\Property(property="id", type="integer", example=1),
     *                 @OA\Property(property="nama", type="string", example="Ahmad Rizki"),
     *                 @OA\Property(property="testimoni", type="string", example="Sekolah Al-Amin telah memberikan pendidikan yang berkualitas tinggi..."),
     *                 @OA\Property(property="foto", type="string", nullable=true, example="1234567890_foto.jpg"),
     *                 @OA\Property(property="foto_url", type="string", nullable=true, example="http://localhost:8000/storage/testimonials/1234567890_foto.jpg"),
     *                 @OA\Property(property="status", type="boolean", example=true),
     *                 @OA\Property(property="created_at", type="string", format="date-time", example="2025-08-29T08:45:43.000000Z"),
     *                 @OA\Property(property="updated_at", type="string", format="date-time", example="2025-08-29T08:45:43.000000Z")
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Testimoni tidak ditemukan",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="boolean", example=false),
     *             @OA\Property(property="message", type="string", example="Testimoni tidak ditemukan"),
     *             @OA\Property(property="data", type="null", example=null)
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Error server",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="boolean", example=false),
     *             @OA\Property(property="message", type="string", example="Terjadi kesalahan pada server"),
     *             @OA\Property(property="data", type="null", example=null)
     *         )
     *     )
     * )
     */
    public function show($id)
    {
        try {
            $testimonial = Testimonial::find($id);

            if (!$testimonial) {
                return response()->json([
                    'status' => false,
                    'message' => 'Testimoni tidak ditemukan',
                    'data' => null
                ], 404);
            }

            $data = [
                'id' => $testimonial->id,
                'nama' => $testimonial->nama,
                'testimoni' => $testimonial->testimoni,
                'foto' => $testimonial->foto,
                'foto_url' => $testimonial->foto ? asset('storage/testimonials/' . $testimonial->foto) : null,
                'status' => (bool) $testimonial->status,
                'created_at' => $testimonial->created_at,
                'updated_at' => $testimonial->updated_at,
            ];

            return response()->json([
                'status' => true,
                'message' => 'Detail testimoni berhasil diambil',
                'data' => $data
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Terjadi kesalahan pada server',
                'data' => null
            ], 500);
        }
    }

    /**
     * @OA\Get(
     *     path="/api/public/testimonials/random/{limit}",
     *     summary="Mendapatkan testimoni acak",
     *     description="Mengambil testimoni acak dengan jumlah yang ditentukan",
     *     tags={"Testimonials"},
     *     @OA\Parameter(
     *         name="limit",
     *         in="path",
     *         description="Jumlah testimoni yang diambil (default: 3)",
     *         required=false,
     *         @OA\Schema(type="integer", example=3, default=3)
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Berhasil mendapatkan testimoni acak",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="Data testimoni acak berhasil diambil"),
     *             @OA\Property(
     *                 property="data",
     *                 type="array",
     *                 @OA\Items(
     *                     @OA\Property(property="id", type="integer", example=1),
     *                     @OA\Property(property="nama", type="string", example="Ahmad Rizki"),
     *                     @OA\Property(property="testimoni", type="string", example="Sekolah Al-Amin telah memberikan pendidikan yang berkualitas tinggi..."),
     *                     @OA\Property(property="foto", type="string", nullable=true, example="1234567890_foto.jpg"),
     *                     @OA\Property(property="foto_url", type="string", nullable=true, example="http://localhost:8000/storage/testimonials/1234567890_foto.jpg"),
     *                     @OA\Property(property="status", type="boolean", example=true),
     *                     @OA\Property(property="created_at", type="string", format="date-time", example="2025-08-29T08:45:43.000000Z"),
     *                     @OA\Property(property="updated_at", type="string", format="date-time", example="2025-08-29T08:45:43.000000Z")
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Error server",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="boolean", example=false),
     *             @OA\Property(property="message", type="string", example="Terjadi kesalahan pada server"),
     *             @OA\Property(property="data", type="null", example=null)
     *         )
     *     )
     * )
     */
    public function random($limit = 3)
    {
        try {
            $testimonials = Testimonial::where('status', 1)
                ->inRandomOrder()
                ->limit($limit)
                ->get()
                ->map(function ($testimonial) {
                    return [
                        'id' => $testimonial->id,
                        'nama' => $testimonial->nama,
                        'testimoni' => $testimonial->testimoni,
                        'foto' => $testimonial->foto,
                        'foto_url' => $testimonial->foto ? asset('storage/testimonials/' . $testimonial->foto) : null,
                        'status' => (bool) $testimonial->status,
                        'created_at' => $testimonial->created_at,
                        'updated_at' => $testimonial->updated_at,
                    ];
                });

            return response()->json([
                'status' => true,
                'message' => 'Data testimoni acak berhasil diambil',
                'data' => $testimonials
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Terjadi kesalahan pada server',
                'data' => null
            ], 500);
        }
    }
}
