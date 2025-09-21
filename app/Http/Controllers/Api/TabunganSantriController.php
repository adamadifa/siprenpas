<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Siswa;
use App\Models\SiswaAnggota;
use App\Models\Tabungan;
use App\Models\Transaksitabungan;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

/**
 * @OA\Tag(
 *     name="Tabungan Santri",
 *     description="API untuk mengelola data tabungan santri dari tabel koperasi_tabungan yang berelasi dengan siswa_anggota dan koperasi_anggota"
 * )
 */
class TabunganSantriController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/tabungan-santri/{id_siswa}",
     *     summary="Mendapatkan data tabungan santri berdasarkan ID Siswa",
     *     tags={"Tabungan Santri"},
     *     security={{"sanctum":{}}},
     *     @OA\Parameter(
     *         name="id_siswa",
     *         in="path",
     *         required=true,
     *         description="ID Siswa",
     *         @OA\Schema(type="string", example="2024001")
     *     ),
     *     @OA\Parameter(
     *         name="include_transactions",
     *         in="query",
     *         required=false,
     *         description="Apakah ingin menyertakan transaksi tabungan",
     *         @OA\Schema(type="boolean", example=false)
     *     ),
     *     @OA\Parameter(
     *         name="limit_transactions",
     *         in="query",
     *         required=false,
     *         description="Jumlah transaksi yang ditampilkan",
     *         @OA\Schema(type="integer", example=10)
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Data tabungan santri berhasil diambil",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="Data tabungan santri berhasil diambil"),
     *             @OA\Property(
     *                 property="data",
     *                 type="object",
     *                 @OA\Property(
     *                     property="siswa",
     *                     type="object",
     *                     @OA\Property(property="id_siswa", type="string", example="2024001"),
     *                     @OA\Property(property="nama_lengkap", type="string", example="Ahmad Rizki"),
     *                     @OA\Property(property="nis", type="string", example="20240001"),
     *                     @OA\Property(property="kelas", type="string", example="X-A")
     *                 ),
     *                 @OA\Property(property="total_saldo", type="integer", example=500000),
     *                 @OA\Property(property="jumlah_rekening", type="integer", example=2),
     *                 @OA\Property(
     *                     property="tabungan",
     *                     type="array",
     *                     @OA\Items(
     *                         type="object",
     *                         @OA\Property(property="no_rekening", type="string", example="001-2024001001"),
     *                         @OA\Property(property="saldo", type="integer", example=250000),
     *                         @OA\Property(property="kode_tabungan", type="string", example="001"),
     *                         @OA\Property(
     *                             property="jenis_tabungan",
     *                             type="object",
     *                             @OA\Property(property="jenis_tabungan", type="string", example="Tabungan Umum")
     *                         ),
     *                         @OA\Property(
     *                             property="anggota",
     *                             type="object",
     *                             @OA\Property(property="nama_lengkap", type="string", example="Ahmad Rizki")
     *                         )
     *                     )
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Siswa tidak ditemukan atau tidak memiliki tabungan",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="success", type="boolean", example=false),
     *             @OA\Property(property="message", type="string", example="Siswa tidak ditemukan atau tidak memiliki tabungan")
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthenticated",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string", example="Unauthenticated.")
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
    public function getTabunganByIdSiswa(Request $request, string $id_siswa): JsonResponse
    {
        try {
            // Cek apakah siswa ada
            $siswa = Siswa::where('id_siswa', $id_siswa)->first();
            if (!$siswa) {
                return response()->json([
                    'success' => false,
                    'message' => 'Siswa tidak ditemukan'
                ], 404);
            }

            // Ambil data tabungan siswa melalui relasi siswa_anggota
            $tabunganQuery = DB::table('koperasi_tabungan as kt')
                ->join('siswa_anggota as sa', 'kt.no_anggota', '=', 'sa.no_anggota')
                ->join('koperasi_anggota as ka', 'kt.no_anggota', '=', 'ka.no_anggota')
                ->join('koperasi_jenis_tabungan as kjt', 'kt.kode_tabungan', '=', 'kjt.kode_tabungan')
                ->where('sa.id_siswa', $id_siswa)
                ->select(
                    'kt.*',
                    'ka.nama_lengkap as nama_anggota',
                    'ka.alamat as alamat_anggota',
                    'ka.no_hp as no_hp_anggota',
                    'kjt.jenis_tabungan'
                );

            $tabungan = $tabunganQuery->get();

            if ($tabungan->isEmpty()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Siswa tidak memiliki tabungan atau belum menjadi anggota koperasi'
                ], 404);
            }

            // Hitung total saldo
            $totalSaldo = $tabungan->sum('saldo');
            $jumlahRekening = $tabungan->count();

            // Format data tabungan
            $dataTabungan = $tabungan->map(function ($item) use ($request) {
                $tabunganData = [
                    'no_rekening' => $item->no_rekening,
                    'no_anggota' => $item->no_anggota,
                    'kode_tabungan' => $item->kode_tabungan,
                    'saldo' => (int) $item->saldo,
                    'created_at' => $item->created_at,
                    'updated_at' => $item->updated_at,
                    'jenis_tabungan' => [
                        'kode_tabungan' => $item->kode_tabungan,
                        'jenis_tabungan' => $item->jenis_tabungan
                    ],
                    'anggota' => [
                        'no_anggota' => $item->no_anggota,
                        'nama_lengkap' => $item->nama_anggota,
                        'alamat' => $item->alamat_anggota,
                        'no_hp' => $item->no_hp_anggota
                    ]
                ];

                // Jika diminta untuk menyertakan transaksi
                if ($request->boolean('include_transactions', false)) {
                    $limitTransactions = $request->integer('limit_transactions', 10);

                    $transaksi = DB::table('koperasi_tabungan_transaksi as ktt')
                        ->join('users as u', 'ktt.id_petugas', '=', 'u.id')
                        ->where('ktt.no_rekening', $item->no_rekening)
                        ->select(
                            'ktt.*',
                            'u.name as nama_petugas'
                        )
                        ->orderBy('ktt.created_at', 'desc')
                        ->limit($limitTransactions)
                        ->get();

                    $tabunganData['transaksi'] = $transaksi->map(function ($trans) {
                        return [
                            'no_transaksi' => $trans->no_transaksi,
                            'tanggal' => $trans->tanggal,
                            'jenis_transaksi' => $trans->jenis_transaksi,
                            'jenis_transaksi_text' => $trans->jenis_transaksi == 'S' ? 'Setor' : 'Tarik',
                            'jumlah' => (int) $trans->jumlah,
                            'saldo' => (int) $trans->saldo,
                            'berita' => $trans->berita,
                            'nama_petugas' => $trans->nama_petugas,
                            'created_at' => $trans->created_at
                        ];
                    });
                }

                return $tabunganData;
            });

            return response()->json([
                'success' => true,
                'message' => 'Data tabungan santri berhasil diambil',
                'data' => [
                    'siswa' => [
                        'id_siswa' => $siswa->id_siswa,
                        'nama_lengkap' => $siswa->nama_lengkap,
                        'nis' => $siswa->nis ?? null,
                        'kelas' => $siswa->kelas ?? null
                    ],
                    'total_saldo' => (int) $totalSaldo,
                    'jumlah_rekening' => $jumlahRekening,
                    'tabungan' => $dataTabungan
                ]
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan server',
                'error' => config('app.debug') ? $e->getMessage() : 'Internal Server Error'
            ], 500);
        }
    }

    /**
     * @OA\Get(
     *     path="/api/tabungan-santri/{id_siswa}/rekening/{no_rekening}",
     *     summary="Mendapatkan detail tabungan santri berdasarkan nomor rekening",
     *     tags={"Tabungan Santri"},
     *     security={{"sanctum":{}}},
     *     @OA\Parameter(
     *         name="id_siswa",
     *         in="path",
     *         required=true,
     *         description="ID Siswa",
     *         @OA\Schema(type="string", example="2024001")
     *     ),
     *     @OA\Parameter(
     *         name="no_rekening",
     *         in="path",
     *         required=true,
     *         description="Nomor Rekening Tabungan",
     *         @OA\Schema(type="string", example="001-2024001001")
     *     ),
     *     @OA\Parameter(
     *         name="limit_transactions",
     *         in="query",
     *         required=false,
     *         description="Jumlah transaksi yang ditampilkan",
     *         @OA\Schema(type="integer", example=20)
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Detail tabungan santri berhasil diambil",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="Detail tabungan santri berhasil diambil"),
     *             @OA\Property(
     *                 property="data",
     *                 type="object",
     *                 @OA\Property(property="no_rekening", type="string", example="001-2024001001"),
     *                 @OA\Property(property="saldo", type="integer", example=250000),
     *                 @OA\Property(property="jenis_tabungan", type="string", example="Tabungan Umum"),
     *                 @OA\Property(property="nama_anggota", type="string", example="Ahmad Rizki"),
     *                 @OA\Property(property="total_transaksi", type="integer", example=10),
     *                 @OA\Property(
     *                     property="transaksi",
     *                     type="array",
     *                     @OA\Items(
     *                         type="object",
     *                         @OA\Property(property="no_transaksi", type="string", example="001241201001"),
     *                         @OA\Property(property="tanggal", type="string", example="2024-12-01"),
     *                         @OA\Property(property="jenis_transaksi", type="string", example="S"),
     *                         @OA\Property(property="jenis_transaksi_text", type="string", example="Setor"),
     *                         @OA\Property(property="jumlah", type="integer", example=50000),
     *                         @OA\Property(property="saldo", type="integer", example=250000),
     *                         @OA\Property(property="berita", type="string", example="Setoran tabungan bulanan"),
     *                         @OA\Property(property="nama_petugas", type="string", example="Admin Koperasi")
     *                     )
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Tabungan tidak ditemukan",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="success", type="boolean", example=false),
     *             @OA\Property(property="message", type="string", example="Tabungan tidak ditemukan atau tidak milik siswa ini")
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthenticated",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string", example="Unauthenticated.")
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
    public function getDetailTabungan(Request $request, string $id_siswa, string $no_rekening): JsonResponse
    {
        try {
            // Validasi apakah tabungan milik siswa tersebut
            $tabungan = DB::table('koperasi_tabungan as kt')
                ->join('siswa_anggota as sa', 'kt.no_anggota', '=', 'sa.no_anggota')
                ->join('koperasi_anggota as ka', 'kt.no_anggota', '=', 'ka.no_anggota')
                ->join('koperasi_jenis_tabungan as kjt', 'kt.kode_tabungan', '=', 'kjt.kode_tabungan')
                ->where('sa.id_siswa', $id_siswa)
                ->where('kt.no_rekening', $no_rekening)
                ->select(
                    'kt.*',
                    'ka.nama_lengkap as nama_anggota',
                    'kjt.jenis_tabungan'
                )
                ->first();

            if (!$tabungan) {
                return response()->json([
                    'success' => false,
                    'message' => 'Tabungan tidak ditemukan atau tidak milik siswa ini'
                ], 404);
            }

            // Ambil transaksi
            $limitTransactions = $request->integer('limit_transactions', 20);

            $transaksi = DB::table('koperasi_tabungan_transaksi as ktt')
                ->join('users as u', 'ktt.id_petugas', '=', 'u.id')
                ->where('ktt.no_rekening', $no_rekening)
                ->select(
                    'ktt.*',
                    'u.name as nama_petugas'
                )
                ->orderBy('ktt.created_at', 'desc')
                ->limit($limitTransactions)
                ->get();

            $dataTransaksi = $transaksi->map(function ($trans) {
                return [
                    'no_transaksi' => $trans->no_transaksi,
                    'tanggal' => $trans->tanggal,
                    'jenis_transaksi' => $trans->jenis_transaksi,
                    'jenis_transaksi_text' => $trans->jenis_transaksi == 'S' ? 'Setor' : 'Tarik',
                    'jumlah' => (int) $trans->jumlah,
                    'saldo' => (int) $trans->saldo,
                    'berita' => $trans->berita,
                    'nama_petugas' => $trans->nama_petugas,
                    'created_at' => $trans->created_at
                ];
            });

            return response()->json([
                'success' => true,
                'message' => 'Detail tabungan santri berhasil diambil',
                'data' => [
                    'no_rekening' => $tabungan->no_rekening,
                    'no_anggota' => $tabungan->no_anggota,
                    'kode_tabungan' => $tabungan->kode_tabungan,
                    'saldo' => (int) $tabungan->saldo,
                    'jenis_tabungan' => $tabungan->jenis_tabungan,
                    'nama_anggota' => $tabungan->nama_anggota,
                    'created_at' => $tabungan->created_at,
                    'updated_at' => $tabungan->updated_at,
                    'transaksi' => $dataTransaksi,
                    'total_transaksi' => $transaksi->count()
                ]
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan server',
                'error' => config('app.debug') ? $e->getMessage() : 'Internal Server Error'
            ], 500);
        }
    }

    /**
     * Menampilkan halaman mobile untuk tabungan santri
     */
    public function showMobile(Request $request, string $id_siswa)
    {
        try {
            // Cek apakah siswa ada
            $siswa = Siswa::where('id_siswa', $id_siswa)->first();
            if (!$siswa) {
                return redirect()->back()->with('error', 'Siswa tidak ditemukan');
            }

            // Ambil data tabungan siswa melalui relasi siswa_anggota
            $tabunganQuery = DB::table('koperasi_tabungan as kt')
                ->join('siswa_anggota as sa', 'kt.no_anggota', '=', 'sa.no_anggota')
                ->join('koperasi_anggota as ka', 'kt.no_anggota', '=', 'ka.no_anggota')
                ->join('koperasi_jenis_tabungan as kjt', 'kt.kode_tabungan', '=', 'kjt.kode_tabungan')
                ->where('sa.id_siswa', $id_siswa)
                ->select(
                    'kt.*',
                    'ka.nama_lengkap as nama_anggota',
                    'ka.alamat as alamat_anggota',
                    'ka.no_hp as no_hp_anggota',
                    'kjt.jenis_tabungan'
                );

            $tabungan = $tabunganQuery->get();

            if ($tabungan->isEmpty()) {
                return redirect()->back()->with('error', 'Siswa tidak memiliki tabungan atau belum menjadi anggota koperasi');
            }

            // Hitung total saldo
            $totalSaldo = $tabungan->sum('saldo');
            $jumlahRekening = $tabungan->count();

            // Format data tabungan
            $dataTabungan = $tabungan->map(function ($item) {
                return [
                    'no_rekening' => $item->no_rekening,
                    'no_anggota' => $item->no_anggota,
                    'kode_tabungan' => $item->kode_tabungan,
                    'saldo' => (int) $item->saldo,
                    'created_at' => $item->created_at,
                    'updated_at' => $item->updated_at,
                    'jenis_tabungan' => [
                        'kode_tabungan' => $item->kode_tabungan,
                        'jenis_tabungan' => $item->jenis_tabungan
                    ],
                    'anggota' => [
                        'no_anggota' => $item->no_anggota,
                        'nama_lengkap' => $item->nama_anggota,
                        'alamat' => $item->alamat_anggota,
                        'no_hp' => $item->no_hp_anggota
                    ]
                ];
            });

            // Ambil 5 transaksi terakhir dari semua tabungan
            $allTransactions = collect();
            foreach ($tabungan as $tab) {
                $transaksi = DB::table('koperasi_tabungan_transaksi as ktt')
                    ->join('users as u', 'ktt.id_petugas', '=', 'u.id')
                    ->join('koperasi_jenis_tabungan as kjt', 'ktt.kode_tabungan', '=', 'kjt.kode_tabungan')
                    ->where('ktt.no_rekening', $tab->no_rekening)
                    ->select(
                        'ktt.*',
                        'u.name as nama_petugas',
                        'kjt.jenis_tabungan'
                    )
                    ->orderBy('ktt.created_at', 'desc')
                    ->limit(5)
                    ->get();

                $allTransactions = $allTransactions->merge($transaksi);
            }

            // Urutkan berdasarkan tanggal terbaru dan ambil 5 teratas
            $transaksi = $allTransactions->sortByDesc('created_at')->take(5)->map(function ($trans) {
                return [
                    'no_transaksi' => $trans->no_transaksi,
                    'tanggal' => $trans->tanggal,
                    'jenis_transaksi' => $trans->jenis_transaksi,
                    'jenis_transaksi_text' => $trans->jenis_transaksi == 'S' ? 'Setor' : 'Tarik',
                    'jumlah' => (int) $trans->jumlah,
                    'saldo' => (int) $trans->saldo,
                    'berita' => $trans->berita,
                    'nama_petugas' => $trans->nama_petugas,
                    'jenis_tabungan' => $trans->jenis_tabungan,
                    'created_at' => $trans->created_at
                ];
            });

            $data = [
                'siswa' => [
                    'id_siswa' => $siswa->id_siswa,
                    'nama_lengkap' => $siswa->nama_lengkap,
                    'nis' => $siswa->nis ?? null,
                    'kelas' => $siswa->kelas ?? null
                ],
                'total_saldo' => (int) $totalSaldo,
                'jumlah_rekening' => $jumlahRekening,
                'tabungan' => $dataTabungan
            ];

            return view('koperasi.tabungan.santri-mobile', compact('siswa', 'data', 'transaksi'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan server: ' . $e->getMessage());
        }
    }
}
