<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\KonfirmasiPembayaranRequest;
use App\Models\KonfirmasiPembayaranGotTalent;
use App\Models\PendaftaranGotTalent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

/**
 * @OA\Tag(
 *     name="Konfirmasi Pembayaran Got Talent",
 *     description="API endpoints untuk konfirmasi pembayaran Al Amin Got Talent"
 * )
 * 
 * @OA\Schema(
 *     schema="KonfirmasiPembayaran",
 *     type="object",
 *     @OA\Property(property="id", type="integer", example=1),
 *     @OA\Property(property="pendaftaran_got_talent_id", type="integer", example=1),
 *     @OA\Property(property="tanggal_pembayaran", type="string", format="date", example="2026-01-15"),
 *     @OA\Property(property="jumlah_pembayaran", type="number", format="float", example=50000),
 *     @OA\Property(property="metode_pembayaran", type="string", enum={"transfer", "tunai"}, example="transfer"),
 *     @OA\Property(property="bukti_pembayaran", type="string", nullable=true, example="http://domain.com/storage/bukti_pembayaran_got_talent/bukti_pembayaran_1_1234567890_abc123.jpg"),
 *     @OA\Property(property="keterangan", type="string", nullable=true, example="Transfer dari BCA"),
 *     @OA\Property(property="status", type="string", enum={"pending", "diverifikasi", "ditolak"}, example="pending"),
 *     @OA\Property(property="catatan_admin", type="string", nullable=true, example="Pembayaran sudah diterima"),
 *     @OA\Property(property="diverifikasi_oleh", type="integer", nullable=true, example=1),
 *     @OA\Property(property="diverifikasi_pada", type="string", format="datetime", nullable=true, example="2026-01-16 14:20:00"),
 *     @OA\Property(property="created_at", type="string", format="datetime", example="2026-01-15 10:30:00"),
 *     @OA\Property(property="updated_at", type="string", format="datetime", example="2026-01-15 10:30:00")
 * )
 * 
 * @OA\Schema(
 *     schema="KonfirmasiPembayaranResponse",
 *     type="object",
 *     @OA\Property(property="success", type="boolean", example=true),
 *     @OA\Property(property="message", type="string", example="Konfirmasi pembayaran berhasil dikirim"),
 *     @OA\Property(
 *         property="data",
 *         ref="#/components/schemas/KonfirmasiPembayaran"
 *     )
 * )
 */
class KonfirmasiPembayaranGotTalentController extends Controller
{
    /**
     * Simpan konfirmasi pembayaran
     * 
     * @OA\Post(
     *     path="/api/pendaftaran-got-talent/konfirmasi-pembayaran",
     *     summary="Kirim konfirmasi pembayaran",
     *     description="Endpoint untuk mengirim konfirmasi pembayaran Al Amin Got Talent. User harus sudah terdaftar dan memiliki pendaftaran aktif.",
     *     tags={"Konfirmasi Pembayaran Got Talent"},
     *     security={{"sanctum":{}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="multipart/form-data",
     *             @OA\Schema(
     *                 required={"tanggal_pembayaran", "jumlah_pembayaran", "metode_pembayaran", "bukti_pembayaran"},
     *                 @OA\Property(property="tanggal_pembayaran", type="string", format="date", example="2026-01-15", description="Tanggal pembayaran (tidak boleh lebih dari hari ini)"),
     *                 @OA\Property(property="jumlah_pembayaran", type="number", format="float", example=50000, description="Jumlah pembayaran (minimal 1)"),
     *                 @OA\Property(property="metode_pembayaran", type="string", enum={"transfer", "tunai"}, example="transfer", description="Metode pembayaran"),
     *                 @OA\Property(property="bukti_pembayaran", type="string", format="binary", description="File bukti pembayaran (JPG, PNG, PDF, maksimal 5MB)"),
     *                 @OA\Property(property="keterangan", type="string", maxLength=500, example="Transfer dari BCA", description="Keterangan tambahan (opsional)")
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Konfirmasi pembayaran berhasil dikirim",
     *         @OA\JsonContent(ref="#/components/schemas/KonfirmasiPembayaranResponse")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Data pendaftaran tidak ditemukan",
     *         @OA\JsonContent(ref="#/components/schemas/ErrorResponse")
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validasi gagal atau sudah ada konfirmasi yang sedang diproses",
     *         @OA\JsonContent(ref="#/components/schemas/ErrorResponse")
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Server error",
     *         @OA\JsonContent(ref="#/components/schemas/ErrorResponse")
     *     )
     * )
     */
    public function store(KonfirmasiPembayaranRequest $request)
    {
        try {
            // Get user yang sedang login (dari token)
            $user = Auth::user();
            
            // Cari pendaftaran berdasarkan user_id
            $pendaftaran = PendaftaranGotTalent::where('user_id', $user->id)
                ->orWhere('email', $user->email)
                ->first();

            if (!$pendaftaran) {
                return response()->json([
                    'success' => false,
                    'message' => 'Data pendaftaran tidak ditemukan',
                ], 404);
            }

            // Cek apakah sudah ada konfirmasi pembayaran yang pending atau diverifikasi
            $existingKonfirmasi = KonfirmasiPembayaranGotTalent::where('pendaftaran_got_talent_id', $pendaftaran->id)
                ->whereIn('status', ['pending', 'diverifikasi'])
                ->first();

            if ($existingKonfirmasi) {
                return response()->json([
                    'success' => false,
                    'message' => 'Anda sudah memiliki konfirmasi pembayaran yang sedang diproses',
                    'data' => $existingKonfirmasi,
                ], 422);
            }

            // Upload file bukti pembayaran
            $buktiPembayaran = null;
            if ($request->hasFile('bukti_pembayaran')) {
                $file = $request->file('bukti_pembayaran');
                $fileName = 'bukti_pembayaran_' . $pendaftaran->id . '_' . time() . '_' . Str::random(10) . '.' . $file->getClientOriginalExtension();
                $path = $file->storeAs('bukti_pembayaran_got_talent', $fileName, 'public');
                $buktiPembayaran = $path;
            }

            // Simpan konfirmasi pembayaran
            $konfirmasi = KonfirmasiPembayaranGotTalent::create([
                'pendaftaran_got_talent_id' => $pendaftaran->id,
                'tanggal_pembayaran' => $request->tanggal_pembayaran,
                'jumlah_pembayaran' => $request->jumlah_pembayaran,
                'metode_pembayaran' => $request->metode_pembayaran,
                'bukti_pembayaran' => $buktiPembayaran,
                'keterangan' => $request->keterangan,
                'status' => 'pending',
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Konfirmasi pembayaran berhasil dikirim',
                'data' => [
                    'id' => $konfirmasi->id,
                    'tanggal_pembayaran' => $konfirmasi->tanggal_pembayaran->format('Y-m-d'),
                    'jumlah_pembayaran' => (float) $konfirmasi->jumlah_pembayaran,
                    'metode_pembayaran' => $konfirmasi->metode_pembayaran,
                    'bukti_pembayaran' => $konfirmasi->bukti_pembayaran_url,
                    'keterangan' => $konfirmasi->keterangan,
                    'status' => $konfirmasi->status,
                    'created_at' => $konfirmasi->created_at->format('Y-m-d H:i:s'),
                ],
            ], 201);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat menyimpan konfirmasi pembayaran',
                'error' => config('app.debug') ? $e->getMessage() : null,
            ], 500);
        }
    }

    /**
     * Get konfirmasi pembayaran user yang sedang login
     * 
     * @OA\Get(
     *     path="/api/pendaftaran-got-talent/get-konfirmasi-pembayaran",
     *     summary="Ambil konfirmasi pembayaran user",
     *     description="Endpoint untuk mengambil data konfirmasi pembayaran terbaru dari user yang sedang login",
     *     tags={"Konfirmasi Pembayaran Got Talent"},
     *     security={{"sanctum":{}}},
     *     @OA\Response(
     *         response=200,
     *         description="Data konfirmasi pembayaran berhasil diambil",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(
     *                 property="data",
     *                 ref="#/components/schemas/KonfirmasiPembayaran"
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Data pendaftaran atau konfirmasi pembayaran tidak ditemukan",
     *         @OA\JsonContent(ref="#/components/schemas/ErrorResponse")
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Server error",
     *         @OA\JsonContent(ref="#/components/schemas/ErrorResponse")
     *     )
     * )
     */
    public function show()
    {
        try {
            $user = Auth::user();
            
            // Cari pendaftaran berdasarkan user_id
            $pendaftaran = PendaftaranGotTalent::where('user_id', $user->id)
                ->orWhere('email', $user->email)
                ->first();

            if (!$pendaftaran) {
                return response()->json([
                    'success' => false,
                    'message' => 'Data pendaftaran tidak ditemukan',
                ], 404);
            }

            // Cari konfirmasi pembayaran
            $konfirmasi = KonfirmasiPembayaranGotTalent::where('pendaftaran_got_talent_id', $pendaftaran->id)
                ->latest()
                ->first();

            if (!$konfirmasi) {
                return response()->json([
                    'success' => false,
                    'message' => 'Konfirmasi pembayaran tidak ditemukan',
                ], 404);
            }

            return response()->json([
                'success' => true,
                'data' => [
                    'id' => $konfirmasi->id,
                    'tanggal_pembayaran' => $konfirmasi->tanggal_pembayaran->format('Y-m-d'),
                    'jumlah_pembayaran' => (float) $konfirmasi->jumlah_pembayaran,
                    'metode_pembayaran' => $konfirmasi->metode_pembayaran,
                    'bukti_pembayaran' => $konfirmasi->bukti_pembayaran_url,
                    'keterangan' => $konfirmasi->keterangan,
                    'status' => $konfirmasi->status,
                    'catatan_admin' => $konfirmasi->catatan_admin,
                    'diverifikasi_pada' => $konfirmasi->diverifikasi_pada ? $konfirmasi->diverifikasi_pada->format('Y-m-d H:i:s') : null,
                    'created_at' => $konfirmasi->created_at->format('Y-m-d H:i:s'),
                    'updated_at' => $konfirmasi->updated_at->format('Y-m-d H:i:s'),
                ],
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat mengambil data konfirmasi pembayaran',
                'error' => config('app.debug') ? $e->getMessage() : null,
            ], 500);
        }
    }

    /**
     * Update status konfirmasi pembayaran (untuk admin)
     * 
     * @OA\Put(
     *     path="/api/admin/konfirmasi-pembayaran-got-talent/{id}/status",
     *     summary="Update status konfirmasi pembayaran (Admin)",
     *     description="Endpoint untuk admin mengupdate status konfirmasi pembayaran (diverifikasi/ditolak)",
     *     tags={"Konfirmasi Pembayaran Got Talent"},
     *     security={{"sanctum":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID konfirmasi pembayaran",
     *         @OA\Schema(type="integer", example=1)
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"status"},
     *             @OA\Property(property="status", type="string", enum={"diverifikasi", "ditolak"}, example="diverifikasi", description="Status baru"),
     *             @OA\Property(property="catatan_admin", type="string", maxLength=500, example="Pembayaran sudah diterima", description="Catatan dari admin (opsional)")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Status berhasil diupdate",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="Status konfirmasi pembayaran berhasil diupdate"),
     *             @OA\Property(
     *                 property="data",
     *                 ref="#/components/schemas/KonfirmasiPembayaran"
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Konfirmasi pembayaran tidak ditemukan",
     *         @OA\JsonContent(ref="#/components/schemas/ErrorResponse")
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validasi gagal",
     *         @OA\JsonContent(ref="#/components/schemas/ErrorResponse")
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Server error",
     *         @OA\JsonContent(ref="#/components/schemas/ErrorResponse")
     *     )
     * )
     */
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:diverifikasi,ditolak',
            'catatan_admin' => 'nullable|string|max:500',
        ]);

        try {
            $konfirmasi = KonfirmasiPembayaranGotTalent::findOrFail($id);
            
            $konfirmasi->update([
                'status' => $request->status,
                'catatan_admin' => $request->catatan_admin,
                'diverifikasi_oleh' => Auth::id(),
                'diverifikasi_pada' => now(),
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Status konfirmasi pembayaran berhasil diupdate',
                'data' => $konfirmasi,
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat mengupdate status',
                'error' => config('app.debug') ? $e->getMessage() : null,
            ], 500);
        }
    }

    /**
     * List semua konfirmasi pembayaran (untuk admin)
     * 
     * @OA\Get(
     *     path="/api/admin/konfirmasi-pembayaran-got-talent",
     *     summary="List semua konfirmasi pembayaran (Admin)",
     *     description="Endpoint untuk admin melihat semua konfirmasi pembayaran dengan filter dan pagination",
     *     tags={"Konfirmasi Pembayaran Got Talent"},
     *     security={{"sanctum":{}}},
     *     @OA\Parameter(
     *         name="status",
     *         in="query",
     *         required=false,
     *         description="Filter berdasarkan status",
     *         @OA\Schema(type="string", enum={"pending", "diverifikasi", "ditolak"}, example="pending")
     *     ),
     *     @OA\Parameter(
     *         name="search",
     *         in="query",
     *         required=false,
     *         description="Search berdasarkan nama, email, atau nomor register",
     *         @OA\Schema(type="string", example="Ahmad")
     *     ),
     *     @OA\Parameter(
     *         name="page",
     *         in="query",
     *         required=false,
     *         description="Halaman",
     *         @OA\Schema(type="integer", example=1)
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="List konfirmasi pembayaran berhasil diambil",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(
     *                 property="data",
     *                 type="object",
     *                 @OA\Property(
     *                     property="data",
     *                     type="array",
     *                     @OA\Items(ref="#/components/schemas/KonfirmasiPembayaran")
     *                 ),
     *                 @OA\Property(property="current_page", type="integer", example=1),
     *                 @OA\Property(property="last_page", type="integer", example=5),
     *                 @OA\Property(property="per_page", type="integer", example=15),
     *                 @OA\Property(property="total", type="integer", example=75)
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Server error",
     *         @OA\JsonContent(ref="#/components/schemas/ErrorResponse")
     *     )
     * )
     */
    public function index(Request $request)
    {
        try {
            $query = KonfirmasiPembayaranGotTalent::with(['pendaftaran', 'verifikator']);

            // Filter by status
            if ($request->has('status')) {
                $query->where('status', $request->status);
            }

            // Search
            if ($request->has('search')) {
                $search = $request->search;
                $query->whereHas('pendaftaran', function($q) use ($search) {
                    $q->where('nama_lengkap', 'like', "%{$search}%")
                      ->orWhere('email', 'like', "%{$search}%");
                });
            }

            $konfirmasi = $query->latest()->paginate(15);

            return response()->json([
                'success' => true,
                'data' => $konfirmasi,
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat mengambil data',
                'error' => config('app.debug') ? $e->getMessage() : null,
            ], 500);
        }
    }
}

