<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

/**
 * @OA\Tag(
 *     name="Rekening",
 *     description="API untuk mendapatkan data rekening tabungan santri"
 * )
 */
class RekeningController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/public/rekening/{rfid}",
     *     summary="Mendapatkan data rekening berdasarkan RFID",
     *     tags={"Rekening"},
     *     @OA\Parameter(
     *         name="X-API-Token",
     *         in="header",
     *         required=true,
     *         description="API Token untuk autentikasi",
     *         @OA\Schema(type="string", example="sipren-api-token-2024")
     *     ),
     *     @OA\Parameter(
     *         name="rfid",
     *         in="path",
     *         required=true,
     *         description="Kode RFID Tabungan",
     *         @OA\Schema(type="string", example="RFID123456")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Data rekening berhasil diambil",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="Data rekening berhasil diambil"),
     *             @OA\Property(
     *                 property="data",
     *                 type="object",
     *                 @OA\Property(property="no_rekening", type="string", example="TAB001"),
     *                 @OA\Property(property="no_anggota", type="string", example="ANG001"),
     *                 @OA\Property(property="kode_tabungan", type="string", example="T01"),
     *                 @OA\Property(property="saldo", type="integer", example=500000),
     *                 @OA\Property(property="rfid", type="string", example="RFID123456"),
     *                 @OA\Property(property="created_at", type="string", format="datetime", example="2024-01-15T10:30:00.000000Z"),
     *                 @OA\Property(property="updated_at", type="string", format="datetime", example="2024-01-15T10:30:00.000000Z"),
     *                 @OA\Property(
     *                     property="jenis_tabungan",
     *                     type="object",
     *                     @OA\Property(property="kode_tabungan", type="string", example="T01"),
     *                     @OA\Property(property="jenis_tabungan", type="string", example="Tabungan Pendidikan")
     *                 ),
     *                 @OA\Property(
     *                     property="anggota",
     *                     type="object",
     *                     @OA\Property(property="no_anggota", type="string", example="ANG001"),
     *                     @OA\Property(property="nama_lengkap", type="string", example="Ahmad Santri"),
     *                     @OA\Property(property="alamat", type="string", example="Jl. Pendidikan No. 123"),
     *                     @OA\Property(property="no_hp", type="string", example="081234567890")
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Rekening dengan RFID tersebut tidak ditemukan",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="success", type="boolean", example=false),
     *             @OA\Property(property="message", type="string", example="Rekening dengan RFID tersebut tidak ditemukan")
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized - Invalid API Token",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="success", type="boolean", example=false),
     *             @OA\Property(property="message", type="string", example="Unauthorized. Invalid or missing API token.")
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Terjadi kesalahan server",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="success", type="boolean", example=false),
     *             @OA\Property(property="message", type="string", example="Terjadi kesalahan server")
     *         )
     *     )
     * )
     */
    public function getRekeningByRfid(Request $request, string $rfid): JsonResponse
    {
        try {
            // Ambil data rekening berdasarkan RFID
            $rekening = DB::table('koperasi_tabungan as kt')
                ->join('koperasi_anggota as ka', 'kt.no_anggota', '=', 'ka.no_anggota')
                ->join('koperasi_jenis_tabungan as kjt', 'kt.kode_tabungan', '=', 'kjt.kode_tabungan')
                ->where('kt.rfid', $rfid)
                ->select(
                    'kt.*',
                    'ka.nama_lengkap as nama_anggota',
                    'ka.alamat as alamat_anggota',
                    'ka.no_hp as no_hp_anggota',
                    'kjt.jenis_tabungan'
                )
                ->first();

            if (!$rekening) {
                return response()->json([
                    'success' => false,
                    'message' => 'Rekening dengan RFID tersebut tidak ditemukan'
                ], 404);
            }

            // Format data rekening
            $dataRekening = [
                'no_rekening' => $rekening->no_rekening,
                'no_anggota' => $rekening->no_anggota,
                'kode_tabungan' => $rekening->kode_tabungan,
                'saldo' => (int) $rekening->saldo,
                'rfid' => $rekening->rfid,
                'created_at' => $rekening->created_at,
                'updated_at' => $rekening->updated_at,
                'jenis_tabungan' => [
                    'kode_tabungan' => $rekening->kode_tabungan,
                    'jenis_tabungan' => $rekening->jenis_tabungan
                ],
                'anggota' => [
                    'no_anggota' => $rekening->no_anggota,
                    'nama_lengkap' => $rekening->nama_anggota,
                    'alamat' => $rekening->alamat_anggota,
                    'no_hp' => $rekening->no_hp_anggota
                ]
            ];

            return response()->json([
                'success' => true,
                'message' => 'Data rekening berhasil diambil',
                'data' => $dataRekening
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan server: ' . $e->getMessage()
            ], 500);
        }
    }
}
