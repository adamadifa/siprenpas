<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Pengumuman;
use Illuminate\Http\Request;

/**
 * @OA\Info(
 *     title="Pengumuman API",
 *     version="1.0.0",
 *     description="API untuk mengelola pengumuman",
 *     @OA\Contact(
 *         email="admin@example.com",
 *         name="API Support"
 *     ),
 *     @OA\License(
 *         name="MIT",
 *         url="https://opensource.org/licenses/MIT"
 *     )
 * )
 * @OA\Server(
 *     url=L5_SWAGGER_CONST_HOST,
 *     description="API Server"
 * )
 */
class PengumumanController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/pengumuman/terbaru",
     *     summary="Mengambil 5 pengumuman terbaru",
     *     tags={"Pengumuman"},
     *     @OA\Response(
     *         response=200,
     *         description="Berhasil mengambil data pengumuman terbaru",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="Data pengumuman terbaru berhasil diambil"),
     *             @OA\Property(
     *                 property="data",
     *                 type="array",
     *                 @OA\Items(
     *                     type="object",
     *                     @OA\Property(property="id", type="integer", example=1),
     *                     @OA\Property(property="judul", type="string", example="Pembayaran UKT"),
     *                     @OA\Property(property="isi", type="string", example="Segera lakukan pembayaran UKT semester ganjil."),
     *                     @OA\Property(property="tanggal", type="string", example="26 Jun 2025"),
     *                     @OA\Property(property="kategori", type="string", example="keuangan"),
     *                     @OA\Property(property="lokasi", type="string", example="Bank Syariah Mandiri, Kampus Pusat")
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Terjadi kesalahan server",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="success", type="boolean", example=false),
     *             @OA\Property(property="message", type="string", example="Terjadi kesalahan pada server")
     *         )
     *     )
     * )
     */
    public function getPengumumanTerbaru()
    {
        try {
            $pengumuman = Pengumuman::with('kategori')
                ->orderBy('tanggal', 'desc')
                ->limit(5)
                ->get()
                ->map(function ($item) {
                    return [
                        'id' => $item->id,
                        'judul' => $item->judul,
                        'isi' => $item->isi,
                        'tanggal' => \Carbon\Carbon::parse($item->tanggal)->format('d M Y'),
                        'kategori' => $item->kategori->nama_kategori,
                        'lokasi' => $item->lokasi ?? '-'
                    ];
                });

            return response()->json([
                'success' => true,
                'message' => 'Data pengumuman terbaru berhasil diambil',
                'data' => $pengumuman
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan pada server: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * @OA\Get(
     *     path="/api/pengumuman",
     *     summary="Mengambil semua pengumuman dengan pagination",
     *     tags={"Pengumuman"},
     *     @OA\Parameter(
     *         name="page",
     *         in="query",
     *         description="Nomor halaman",
     *         required=false,
     *         @OA\Schema(type="integer", default=1)
     *     ),
     *     @OA\Parameter(
     *         name="per_page",
     *         in="query",
     *         description="Jumlah data per halaman",
     *         required=false,
     *         @OA\Schema(type="integer", default=10)
     *     ),
     *     @OA\Parameter(
     *         name="kategori_id",
     *         in="query",
     *         description="Filter berdasarkan ID kategori",
     *         required=false,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Berhasil mengambil data pengumuman",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="Data pengumuman berhasil diambil"),
     *             @OA\Property(
     *                 property="data",
     *                 type="array",
     *                 @OA\Items(
     *                     type="object",
     *                     @OA\Property(property="id", type="integer", example=1),
     *                     @OA\Property(property="judul", type="string", example="Pembayaran UKT"),
     *                     @OA\Property(property="isi", type="string", example="Segera lakukan pembayaran UKT semester ganjil."),
     *                     @OA\Property(property="tanggal", type="string", example="26 Jun 2025"),
     *                     @OA\Property(property="kategori", type="string", example="keuangan"),
     *                     @OA\Property(property="lokasi", type="string", example="Bank Syariah Mandiri, Kampus Pusat")
     *                 )
     *             ),
     *             @OA\Property(
     *                 property="pagination",
     *                 type="object",
     *                 @OA\Property(property="current_page", type="integer", example=1),
     *                 @OA\Property(property="per_page", type="integer", example=10),
     *                 @OA\Property(property="total", type="integer", example=25),
     *                 @OA\Property(property="last_page", type="integer", example=3)
     *             )
     *         )
     *     )
     * )
     */
    public function index(Request $request)
    {
        try {
            $query = Pengumuman::with('kategori');

            // Filter berdasarkan kategori
            if ($request->filled('kategori_id')) {
                $query->where('kategori_id', $request->kategori_id);
            }

            $perPage = $request->get('per_page', 10);
            $pengumuman = $query->orderBy('tanggal', 'desc')
                ->paginate($perPage);

            $data = $pengumuman->getCollection()->map(function ($item) {
                return [
                    'id' => $item->id,
                    'judul' => $item->judul,
                    'isi' => $item->isi,
                    'tanggal' => \Carbon\Carbon::parse($item->tanggal)->format('d M Y'),
                    'kategori' => $item->kategori->nama_kategori,
                    'lokasi' => $item->lokasi ?? '-'
                ];
            });

            return response()->json([
                'success' => true,
                'message' => 'Data pengumuman berhasil diambil',
                'data' => $data,
                'pagination' => [
                    'current_page' => $pengumuman->currentPage(),
                    'per_page' => $pengumuman->perPage(),
                    'total' => $pengumuman->total(),
                    'last_page' => $pengumuman->lastPage()
                ]
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan pada server: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * @OA\Get(
     *     path="/api/pengumuman/{id}",
     *     summary="Mengambil detail pengumuman berdasarkan ID",
     *     tags={"Pengumuman"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID pengumuman",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Berhasil mengambil detail pengumuman",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="Detail pengumuman berhasil diambil"),
     *             @OA\Property(
     *                 property="data",
     *                 type="object",
     *                 @OA\Property(property="id", type="integer", example=1),
     *                 @OA\Property(property="judul", type="string", example="Pembayaran UKT"),
     *                 @OA\Property(property="isi", type="string", example="Segera lakukan pembayaran UKT semester ganjil."),
     *                 @OA\Property(property="tanggal", type="string", example="26 Jun 2025"),
     *                 @OA\Property(property="kategori", type="string", example="keuangan"),
     *                 @OA\Property(property="lokasi", type="string", example="Bank Syariah Mandiri, Kampus Pusat")
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Pengumuman tidak ditemukan",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="success", type="boolean", example=false),
     *             @OA\Property(property="message", type="string", example="Pengumuman tidak ditemukan")
     *         )
     *     )
     * )
     */
    public function show($id)
    {
        try {
            $pengumuman = Pengumuman::with('kategori')->find($id);

            if (!$pengumuman) {
                return response()->json([
                    'success' => false,
                    'message' => 'Pengumuman tidak ditemukan'
                ], 404);
            }

            $data = [
                'id' => $pengumuman->id,
                'judul' => $pengumuman->judul,
                'isi' => $pengumuman->isi,
                'tanggal' => \Carbon\Carbon::parse($pengumuman->tanggal)->format('d M Y'),
                'kategori' => $pengumuman->kategori->nama_kategori,
                'lokasi' => $pengumuman->lokasi ?? '-'
            ];

            return response()->json([
                'success' => true,
                'message' => 'Detail pengumuman berhasil diambil',
                'data' => $data
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan pada server: ' . $e->getMessage()
            ], 500);
        }
    }
}
