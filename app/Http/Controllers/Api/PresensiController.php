<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\PresensiSiswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PresensiController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/presensi-siswa",
     *     tags={"Presensi"},
     *     summary="Ambil data presensi harian siswa",
     *     @OA\Parameter(
     *         name="no_pendaftaran",
     *         in="query",
     *         required=true,
     *         @OA\Schema(type="string"),
     *         description="Nomor Pendaftaran Siswa"
     *     ),
     *     @OA\Parameter(
     *         name="bulan",
     *         in="query",
     *         required=false,
     *         @OA\Schema(type="integer"),
     *         description="Bulan (1-12)"
     *     ),
     *     @OA\Parameter(
     *         name="tahun",
     *         in="query",
     *         required=false,
     *         @OA\Schema(type="integer"),
     *         description="Tahun (e.g. 2024)"
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Berhasil ambil data presensi",
     *         @OA\JsonContent(type="object")
     *     )
     * )
     */
    public function presensiSiswa(Request $request)
    {
        $request->validate([
            'no_pendaftaran' => 'required|string',
            'bulan' => 'nullable|integer|min:1|max:12',
            'tahun' => 'nullable|integer',
        ]);

        $no_pendaftaran = $request->no_pendaftaran;
        $bulan = $request->bulan ?? date('m');
        $tahun = $request->tahun ?? date('Y');

        $presensi = PresensiSiswa::where('no_pendaftaran', $no_pendaftaran)
            ->whereMonth('tanggal', $bulan)
            ->whereYear('tanggal', $tahun)
            ->orderBy('tanggal', 'desc')
            ->get();

        $rekap = [
            'h' => $presensi->where('status', 'h')->count(),
            'i' => $presensi->where('status', 'i')->count(),
            's' => $presensi->where('status', 's')->count(),
            'a' => $presensi->where('status', 'a')->count(),
        ];

        return response()->json([
            'success' => true,
            'data' => $presensi,
            'rekap' => $rekap,
            'period' => [
                'bulan' => $bulan,
                'tahun' => $tahun
            ]
        ]);
    }

    /**
     * @OA\Get(
     *     path="/api/presensi-mapel",
     *     tags={"Presensi"},
     *     summary="Ambil data presensi per mata pelajaran",
     *     @OA\Parameter(
     *         name="id_siswa",
     *         in="query",
     *         required=true,
     *         @OA\Schema(type="string"),
     *         description="ID Siswa"
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Berhasil ambil data presensi mapel",
     *         @OA\JsonContent(type="array", @OA\Items(type="object"))
     *     )
     * )
     */
    public function presensiMapel(Request $request)
    {
        $request->validate([
            'id_siswa' => 'required|string',
        ]);

        $id_siswa = $request->id_siswa;

        $presensi = DB::table('presensi_mapel_detail')
            ->join('presensi_mapel', 'presensi_mapel_detail.presensi_mapel_id', '=', 'presensi_mapel.id')
            ->join('mata_pelajaran', 'presensi_mapel.mata_pelajaran_id', '=', 'mata_pelajaran.id')
            ->join('guru', 'presensi_mapel.guru_id', '=', 'guru.id')
            ->where('presensi_mapel_detail.siswa_id', $id_siswa)
            ->select(
                'presensi_mapel_detail.*',
                'presensi_mapel.tanggal',
                'presensi_mapel.jam_mulai',
                'presensi_mapel.jam_selesai',
                'presensi_mapel.materi',
                'mata_pelajaran.nama_mata_pelajaran',
                'guru.nama_lengkap as nama_guru'
            )
            ->orderBy('presensi_mapel.tanggal', 'desc')
            ->get();

        return response()->json([
            'success' => true,
            'data' => $presensi
        ]);
    }
}
