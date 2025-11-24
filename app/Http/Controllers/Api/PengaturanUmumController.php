<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\PengaturanUmum;
use Illuminate\Http\Request;

/**
 * @OA\Tag(
 *     name="Pengaturan Umum",
 *     description="API endpoints untuk mendapatkan data pengaturan umum aplikasi"
 * )
 * 
 * @OA\Schema(
 *     schema="PengaturanUmum",
 *     type="object",
 *     @OA\Property(property="id", type="integer", example=1),
 *     @OA\Property(property="nama_aplikasi", type="string", nullable=true, example="SIP 80"),
 *     @OA\Property(property="nama_sekolah", type="string", example="Pesantren Al Amin"),
 *     @OA\Property(property="alamat_sekolah", type="string", example="Jl. Raya No. 123, Bandung"),
 *     @OA\Property(property="telepon", type="string", nullable=true, example="081234567890"),
 *     @OA\Property(property="email", type="string", nullable=true, example="info@pesantren.com"),
 *     @OA\Property(property="website", type="string", nullable=true, example="https://pesantren.com"),
 *     @OA\Property(property="logo", type="string", nullable=true, example="http://localhost/storage/logos/logo.png"),
 *     @OA\Property(property="background_login", type="string", nullable=true, example="http://localhost/storage/backgrounds/bg.png"),
 *     @OA\Property(property="model_1", type="string", nullable=true, example="http://localhost/storage/models/model_1_1234567890.jpg"),
 *     @OA\Property(property="model_2", type="string", nullable=true, example="http://localhost/storage/models/model_2_1234567890.jpg"),
 *     @OA\Property(property="model_3", type="string", nullable=true, example="http://localhost/storage/models/model_3_1234567890.jpg"),
 *     @OA\Property(property="model_4", type="string", nullable=true, example="http://localhost/storage/models/model_4_1234567890.jpg"),
 *     @OA\Property(property="created_at", type="string", format="date-time", example="2024-01-01T00:00:00.000000Z"),
 *     @OA\Property(property="updated_at", type="string", format="date-time", example="2024-01-01T00:00:00.000000Z")
 * )
 */
class PengaturanUmumController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/public/pengaturan-umum",
     *     summary="Mendapatkan data pengaturan umum aplikasi",
     *     description="Mengembalikan data pengaturan umum seperti nama aplikasi, nama sekolah, alamat, kontak, logo, dan background login. Endpoint ini dapat diakses secara publik tanpa autentikasi. Jika data belum tersedia, field 'data' akan bernilai null dan akan ada field 'message'.",
     *     tags={"Pengaturan Umum"},
     *     operationId="getPengaturanUmum",
     *     @OA\Response(
     *         response=200,
     *         description="Berhasil mengambil data pengaturan umum",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="string", example="success"),
     *             @OA\Property(
     *                 property="data",
     *                 type="object",
     *                 nullable=true,
     *                 ref="#/components/schemas/PengaturanUmum"
     *             ),
     *             @OA\Property(property="message", type="string", nullable=true, example="Data pengaturan umum belum tersedia")
     *         )
     *     )
     * )
     */
    public function index()
    {
        $pengaturan = PengaturanUmum::first();

        if ($pengaturan) {
            // Format URL untuk logo dan background_login jika ada
            $data = $pengaturan->toArray();
            
            if (!empty($data['logo'])) {
                $data['logo'] = asset('storage/' . $data['logo']);
            }
            
            if (!empty($data['background_login'])) {
                $data['background_login'] = asset('storage/' . $data['background_login']);
            }

            // Format URL untuk model jika ada
            for ($i = 1; $i <= 4; $i++) {
                $fieldName = 'model_' . $i;
                if (!empty($data[$fieldName])) {
                    $data[$fieldName] = asset('storage/' . $data[$fieldName]);
                }
            }

            return response()->json([
                'status' => 'success',
                'data' => $data,
            ]);
        }

        return response()->json([
            'status' => 'success',
            'data' => null,
            'message' => 'Data pengaturan umum belum tersedia'
        ]);
    }
}

