<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Tabungan;
use App\Models\Transaksitabungan;
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

    /**
     * @OA\Post(
     *     path="/api/public/rekening/transfer",
     *     summary="Transfer antar rekening tabungan",
     *     tags={"Rekening"},
     *     @OA\Parameter(
     *         name="X-API-Token",
     *         in="header",
     *         required=true,
     *         description="API Token untuk autentikasi",
     *         @OA\Schema(type="string", example="sipren-api-token-2024")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"rekening_pengirim","rekening_penerima","jumlah"},
     *             @OA\Property(property="rekening_pengirim", type="string", example="TAB001", description="No rekening pengirim"),
     *             @OA\Property(property="rekening_penerima", type="string", example="TAB002", description="No rekening penerima"),
     *             @OA\Property(property="jumlah", type="number", example=100000, description="Jumlah transfer"),
     *             @OA\Property(property="berita", type="string", example="PAYMENT-KOPERASI", description="Keterangan transfer (default: PAYMENT-KOPERASI)")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Transfer berhasil dilakukan",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="Transfer berhasil dilakukan"),
     *             @OA\Property(
     *                 property="data",
     *                 type="object",
     *                 @OA\Property(property="no_transaksi_tarik", type="string", example="T01-24-01-001"),
     *                 @OA\Property(property="no_transaksi_setor", type="string", example="T01-24-01-002"),
     *                 @OA\Property(property="jumlah", type="number", example=100000),
     *                 @OA\Property(property="saldo_pengirim", type="number", example=400000),
     *                 @OA\Property(property="saldo_penerima", type="number", example=600000)
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Bad Request - Data tidak valid",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="success", type="boolean", example=false),
     *             @OA\Property(property="message", type="string", example="Saldo tidak mencukupi")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Rekening tidak ditemukan",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="success", type="boolean", example=false),
     *             @OA\Property(property="message", type="string", example="Rekening pengirim tidak ditemukan")
     *         )
     *     )
     * )
     */
    public function transfer(Request $request): JsonResponse
    {
        try {
            $request->validate([
                'rekening_pengirim' => 'required|string',
                'rekening_penerima' => 'required|string',
                'jumlah' => 'required|numeric|min:1',
                'berita' => 'nullable|string|max:255'
            ]);

            $rekeningPengirim = $request->rekening_pengirim;
            $rekeningPenerima = $request->rekening_penerima;
            $jumlah = (int) $request->jumlah;
            $berita = $request->berita ?? 'PAYMENT-KOPERASI';

            // Validasi rekening tidak boleh sama
            if ($rekeningPengirim === $rekeningPenerima) {
                return response()->json([
                    'success' => false,
                    'message' => 'Rekening pengirim dan penerima tidak boleh sama'
                ], 400);
            }

            // Cek rekening pengirim
            $tabunganPengirim = Tabungan::where('no_rekening', $rekeningPengirim)->first();
            if (!$tabunganPengirim) {
                return response()->json([
                    'success' => false,
                    'message' => 'Rekening pengirim tidak ditemukan'
                ], 404);
            }

            // Cek rekening penerima
            $tabunganPenerima = Tabungan::where('no_rekening', $rekeningPenerima)->first();
            if (!$tabunganPenerima) {
                return response()->json([
                    'success' => false,
                    'message' => 'Rekening penerima tidak ditemukan'
                ], 404);
            }

            // Cek saldo pengirim
            if ($tabunganPengirim->saldo < $jumlah) {
                return response()->json([
                    'success' => false,
                    'message' => 'Saldo tidak mencukupi'
                ], 400);
            }

            $tanggal = date('Y-m-d');
            $tgl = explode("-", $tanggal);
            $tahun = $tgl[0];
            $bulan = $tgl[1];

            DB::beginTransaction();

            try {
                // Generate no transaksi untuk pengirim (Tarik)
                $formatPengirim = $tabunganPengirim->kode_tabungan . substr($tahun, 2, 2) . $bulan;
                $lastTransaksiPengirim = Transaksitabungan::select('no_transaksi')
                    ->where(DB::raw('left(no_transaksi,7)'), $formatPengirim)
                    ->orderBy('no_transaksi', 'desc')
                    ->first();
                $lastNoTransaksiPengirim = $lastTransaksiPengirim ? $lastTransaksiPengirim->no_transaksi : '';
                $noTransaksiTarik = buatkode($lastNoTransaksiPengirim, $formatPengirim . "-", 3);

                // Generate no transaksi untuk penerima (Setor)
                $formatPenerima = $tabunganPenerima->kode_tabungan . substr($tahun, 2, 2) . $bulan;
                $lastTransaksiPenerima = Transaksitabungan::select('no_transaksi')
                    ->where(DB::raw('left(no_transaksi,7)'), $formatPenerima)
                    ->orderBy('no_transaksi', 'desc')
                    ->first();
                $lastNoTransaksiPenerima = $lastTransaksiPenerima ? $lastTransaksiPenerima->no_transaksi : '';
                $noTransaksiSetor = buatkode($lastNoTransaksiPenerima, $formatPenerima . "-", 3);

                // Insert transaksi tarik (pengirim)
                Transaksitabungan::create([
                    'no_transaksi' => $noTransaksiTarik,
                    'tanggal' => $tanggal,
                    'no_rekening' => $rekeningPengirim,
                    'jumlah' => $jumlah,
                    'jenis_transaksi' => 'T',
                    'berita' => $berita . ' (Transfer ke ' . $rekeningPenerima . ')',
                    'saldo' => 0,
                    'id_petugas' => 1 // Default system user
                ]);

                // Insert transaksi setor (penerima)
                Transaksitabungan::create([
                    'no_transaksi' => $noTransaksiSetor,
                    'tanggal' => $tanggal,
                    'no_rekening' => $rekeningPenerima,
                    'jumlah' => $jumlah,
                    'jenis_transaksi' => 'S',
                    'berita' => $berita . ' (Transfer dari ' . $rekeningPengirim . ')',
                    'saldo' => 0,
                    'id_petugas' => 1 // Default system user
                ]);

                // Update saldo pengirim (kurangi)
                Tabungan::where('no_rekening', $rekeningPengirim)
                    ->update(['saldo' => DB::raw('saldo - ' . $jumlah)]);

                // Update saldo penerima (tambah)
                Tabungan::where('no_rekening', $rekeningPenerima)
                    ->update(['saldo' => DB::raw('saldo + ' . $jumlah)]);

                // Update saldo di transaksi
                $saldoPengirimTerakhir = Tabungan::select('saldo')->where('no_rekening', $rekeningPengirim)->first();
                $saldoPenerimaTerakhir = Tabungan::select('saldo')->where('no_rekening', $rekeningPenerima)->first();

                Transaksitabungan::where('no_transaksi', $noTransaksiTarik)
                    ->update(['saldo' => $saldoPengirimTerakhir->saldo]);

                Transaksitabungan::where('no_transaksi', $noTransaksiSetor)
                    ->update(['saldo' => $saldoPenerimaTerakhir->saldo]);

                DB::commit();

                return response()->json([
                    'success' => true,
                    'message' => 'Transfer berhasil dilakukan',
                    'data' => [
                        'no_transaksi_tarik' => $noTransaksiTarik,
                        'no_transaksi_setor' => $noTransaksiSetor,
                        'jumlah' => $jumlah,
                        'saldo_pengirim' => $saldoPengirimTerakhir->saldo,
                        'saldo_penerima' => $saldoPenerimaTerakhir->saldo
                    ]
                ], 200);
            } catch (\Exception $e) {
                DB::rollback();
                throw $e;
            }
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }
}
