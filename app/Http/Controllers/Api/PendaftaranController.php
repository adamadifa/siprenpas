<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Biayasiswa;
use App\Models\Detailhistoribayarpendidikan;
use App\Models\Detailrencanaspp;
use App\Models\Kelassiswa;
use Illuminate\Http\Request;
use App\Models\Pendaftaran;
use App\Models\Siswa;
use App\Models\Tahunajaran;
use App\Models\Unit;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;

class PendaftaranController extends Controller
{
    /**
     * @OA\Post(
     *     path="/api/unit-by-id-siswa",
     *     tags={"Pendaftaran"},
     *     summary="Dapatkan data unit berdasarkan id_siswa",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"id_siswa"},
     *             @OA\Property(property="id_siswa", type="string", example="123456")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Berhasil ambil data unit",
     *         @OA\JsonContent(type="array", @OA\Items(type="object",
     *             @OA\Property(property="no_pendaftaran", type="string"),
     *             @OA\Property(property="nama_unit", type="string")
     *         ))
     *     )
     * )
     */
    public function unitByIdSiswa(Request $request)
    {
        $request->validate([
            'id_siswa' => 'required|string',
        ]);
        $pendaftaran = Pendaftaran::where('id_siswa', $request->id_siswa)
            ->join('unit', 'pendaftaran.kode_unit', 'unit.kode_unit')
            ->select('pendaftaran.no_pendaftaran', 'nama_unit')
            ->get();
        return response()->json($pendaftaran);
    }



    /**
     * @OA\Get(
     *     path="/api/siswa-by-id-siswa",
     *     tags={"Pendaftaran"},
     *     summary="Ambil data siswa berdasarkan id_siswa",
     *     @OA\Parameter(
     *         name="id_siswa",
     *         in="query",
     *         required=true,
     *         @OA\Schema(type="string"),
     *         description="ID Siswa"
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Berhasil ambil data siswa",
     *         @OA\JsonContent(type="object")
     *     ),
     *     @OA\Response(response=422, description="Parameter id_siswa wajib diisi")
     * )
     */
    public function siswaByIdSiswa(Request $request)
    {
        $id_siswa = $request->query('id_siswa');
        if (!$id_siswa) {
            return response()->json(['error' => 'Parameter id_siswa wajib diisi'], 422);
        }
        $ta_aktif = Tahunajaran::where('status', 1)->first();
        $kelas_siswa = Kelassiswa::join('kelas', 'kelas_siswa.kode_kelas', 'kelas.kode_kelas')
            ->select('kelas_siswa.id_siswa', 'nama_kelas')
            ->where('kelas.kode_ta', $ta_aktif->kode_ta);
        $query = Biayasiswa::query();
        $query->select(
            'pendaftaran.id_siswa',
            'pendaftaran.no_pendaftaran',
            'tahun_ajaran',
            'pendaftaran.nis',
            'kelas_siswa.nama_kelas',
            'konfigurasi_biaya.tingkat',
            'nama_unit',
            'logo'
        );
        $query->join('pendaftaran', 'siswa_biaya.no_pendaftaran', 'pendaftaran.no_pendaftaran');
        $query->join('unit', 'pendaftaran.kode_unit', 'unit.kode_unit');
        $query->join('konfigurasi_biaya', 'siswa_biaya.kode_biaya', 'konfigurasi_biaya.kode_biaya');
        $query->leftjoin('asal_sekolah', 'pendaftaran.kode_asal_sekolah', 'asal_sekolah.kode_asal_sekolah');
        $query->join('konfigurasi_tahunajaran_ppdb', 'konfigurasi_biaya.kode_ta', 'konfigurasi_tahunajaran_ppdb.kode_ta');
        $query->leftJoinSub($kelas_siswa, 'kelas_siswa', function ($join) {
            $join->on('kelas_siswa.id_siswa', '=', 'pendaftaran.id_siswa');
        });
        $query->where('konfigurasi_biaya.kode_ta', $ta_aktif->kode_ta);

        // Filter berdasarkan id_siswa dari query string
        $query->where('pendaftaran.id_siswa', $id_siswa);



        $siswa = Siswa::leftJoinSub($query, 'siswa_biaya', function ($join) {
            $join->on('siswa.id_siswa', '=', 'siswa_biaya.id_siswa');
        })
            ->select(
                'siswa.*',
                'siswa_biaya.no_pendaftaran',
                'siswa_biaya.tahun_ajaran',
                'siswa_biaya.nis',
                'siswa_biaya.nama_kelas',
                'siswa_biaya.tingkat',
                'siswa_biaya.nama_unit',
                'siswa_biaya.logo',
                'districts.name as nama_kota'
            )
            ->where('siswa.id_siswa', $request->id_siswa)
            ->join('districts', 'siswa.id_district', 'districts.id')
            ->first();
        return response()->json($siswa);
    }

    public function getbiayasiswaByNoPendaftaran(Request $request)
    {
        $no_pendaftaran = $request->no_pendaftaran;
        $mpendaftaran = new Pendaftaran();
        $pendaftaran = $mpendaftaran->getPendaftaran($no_pendaftaran)->first();

        // $qpotongan = Potonganpendaftaran::where('no_pendaftaran', $no_pendaftaran)
        //     ->where('kode_biaya', $pendaftaran->kode_biaya);


        // $qmutasi = Mutasipembayaranpendidikan::where('no_pendaftaran', $no_pendaftaran)
        //     ->where('kode_biaya', $pendaftaran->kode_biaya);


        // $biaya = Detailbiaya::where('konfigurasi_biaya_detail.kode_biaya', $pendaftaran->kode_biaya)
        //     ->select(
        //         'konfigurasi_biaya_detail.*',
        //         'potongan.jumlah as jumlah_potongan',
        //         'mutasi.jumlah as jumlah_mutasi',
        //         'jenis_biaya',
        //     )
        //     ->join('konfigurasi_biaya', 'konfigurasi_biaya.kode_biaya', '=', 'konfigurasi_biaya_detail.kode_biaya')
        //     ->join('jenis_biaya', 'jenis_biaya.kode_jenis_biaya', '=', 'konfigurasi_biaya_detail.kode_jenis_biaya')
        //     ->leftjoinSub($qpotongan, 'potongan', function ($join) {
        //         $join->on('konfigurasi_biaya_detail.kode_jenis_biaya', '=', 'potongan.kode_jenis_biaya');
        //     })
        //     ->leftjoinSub($qmutasi, 'mutasi', function ($join) {
        //         $join->on('konfigurasi_biaya_detail.kode_jenis_biaya', '=', 'mutasi.kode_jenis_biaya');
        //     })
        //     ->orderBy('konfigurasi_biaya_detail.kode_jenis_biaya')
        //     ->get();

        $historibayar = Detailhistoribayarpendidikan::where('no_pendaftaran', $no_pendaftaran)
            ->join('pendidikan_historibayar', 'pendidikan_historibayar_detail.no_bukti', '=', 'pendidikan_historibayar.no_bukti')
            ->select(
                'no_pendaftaran',
                'kode_biaya',
                'kode_jenis_biaya',
                DB::raw('SUM(jumlah) as jmlbayar')
            )
            ->groupBy('no_pendaftaran', 'kode_biaya', 'kode_jenis_biaya');
        $biaya = Biayasiswa::where('siswa_biaya.no_pendaftaran', $no_pendaftaran)
            ->select(
                'konfigurasi_biaya_detail.*',
                'pendaftaran_potongan.jumlah as jumlah_potongan',
                'pembayaran_pendidikan_mutasi.jumlah as jumlah_mutasi',
                'jenis_biaya',
                'jmlbayar',
                'tahun_ajaran'
            )
            ->join('konfigurasi_biaya', 'konfigurasi_biaya.kode_biaya', '=', 'siswa_biaya.kode_biaya')
            ->join('konfigurasi_biaya_detail', 'konfigurasi_biaya_detail.kode_biaya', '=', 'konfigurasi_biaya.kode_biaya')
            ->join('jenis_biaya', 'jenis_biaya.kode_jenis_biaya', '=', 'konfigurasi_biaya_detail.kode_jenis_biaya')
            ->join('konfigurasi_tahunajaran_ppdb', 'konfigurasi_tahunajaran_ppdb.kode_ta', '=', 'konfigurasi_biaya.kode_ta')
            ->leftJoin('pendaftaran_potongan', function ($join) {
                $join->on('pendaftaran_potongan.kode_biaya', '=', 'konfigurasi_biaya.kode_biaya')
                    ->on('pendaftaran_potongan.kode_jenis_biaya', '=', 'konfigurasi_biaya_detail.kode_jenis_biaya')
                    ->on('pendaftaran_potongan.no_pendaftaran', '=', 'siswa_biaya.no_pendaftaran');
            })
            ->leftJoin('pembayaran_pendidikan_mutasi', function ($join) {
                $join->on('pembayaran_pendidikan_mutasi.kode_biaya', '=', 'konfigurasi_biaya.kode_biaya')
                    ->on('pembayaran_pendidikan_mutasi.kode_jenis_biaya', '=', 'konfigurasi_biaya_detail.kode_jenis_biaya')
                    ->on('pembayaran_pendidikan_mutasi.no_pendaftaran', '=', 'siswa_biaya.no_pendaftaran');
            })
            ->leftJoinSub($historibayar, 'historibayar', function ($join) {
                $join->on('historibayar.no_pendaftaran', '=', 'siswa_biaya.no_pendaftaran')
                    ->on('historibayar.kode_biaya', '=', 'konfigurasi_biaya.kode_biaya')
                    ->on('historibayar.kode_jenis_biaya', '=', 'konfigurasi_biaya_detail.kode_jenis_biaya');
            })
            ->orderBy('konfigurasi_biaya.kode_biaya', 'asc')
            ->orderBy('konfigurasi_biaya_detail.kode_jenis_biaya', 'asc')
            ->get();
        return response()->json($biaya);
    }



    /**
     * @OA\Get(
     *     path="/getrencanaspp-by-kodebiaya",
     *     tags={"Pendaftaran"},
     *     summary="Ambil rencana spp berdasarkan kode_biaya",
     *     @OA\Parameter(
     *         name="kode_biaya",
     *         in="query",
     *         required=true,
     *         @OA\Schema(type="string"),
     *         description="Kode biaya"
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Berhasil ambil rencana spp",
     *         @OA\JsonContent(type="array", @OA\Items(type="object"))
     *     )
     * )
     */
    public function getRencanasppbyKodeBiaya(Request $request)
    {
        $kode_biaya = $request->kode_biaya;
        $no_pendaftaran = $request->no_pendaftaran;
        $detailrencanaspp = Detailrencanaspp::join('spp_rencana', 'spp_rencana_detail.kode_rencana_spp', '=', 'spp_rencana.kode_rencana_spp')
            ->join('konfigurasi_biaya', 'spp_rencana.kode_biaya', '=', 'konfigurasi_biaya.kode_biaya')
            ->join('konfigurasi_tahunajaran_ppdb', 'konfigurasi_biaya.kode_ta', '=', 'konfigurasi_tahunajaran_ppdb.kode_ta')
            ->where('no_pendaftaran', $no_pendaftaran)
            ->where('spp_rencana.kode_biaya', $kode_biaya)
            ->orderBy('konfigurasi_biaya.kode_ta')
            ->orderBy('spp_rencana_detail.tahun')
            ->orderBy('spp_rencana_detail.bulan')
            ->get();
        return response()->json($detailrencanaspp);
    }


    /**
     * @OA\Get(
     *     path="/gethistoribayar-by-idsiswa",
     *     tags={"Pendaftaran"},
     *     summary="Ambil histori pembayaran berdasarkan id_siswa",
     *     @OA\Parameter(
     *         name="id_siswa",
     *         in="query",
     *         required=true,
     *         @OA\Schema(type="string"),
     *         description="ID Siswa"
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Berhasil ambil histori pembayaran",
     *         @OA\JsonContent(type="array", @OA\Items(type="object"))
     *     )
     * )
     */
    public function getHistoribayarbyIdsiswa(Request $request)
    {
        $id_siswa = $request->id_siswa;
        $historibayar = Detailhistoribayarpendidikan::where('pendaftaran.id_siswa', $id_siswa)
            ->select('pendidikan_historibayar_detail.no_bukti', 'tanggal', 'name', DB::raw('SUM(jumlah) as jumlah'), 'keterangan')
            ->join('pendidikan_historibayar', 'pendidikan_historibayar_detail.no_bukti', '=', 'pendidikan_historibayar.no_bukti')
            ->join('pendaftaran', 'pendidikan_historibayar.no_pendaftaran', '=', 'pendaftaran.no_pendaftaran')
            ->join('users', 'pendidikan_historibayar.id_user', '=', 'users.id')
            ->groupBy('no_bukti', 'tanggal', 'name', 'keterangan')
            ->orderBy('no_bukti', 'desc')
            ->get();
        return response()->json($historibayar);
    }


    /**
     * @OA\Get(
     *     path="/getdetailhistoribayar",
     *     tags={"Pendaftaran"},
     *     summary="Ambil detail histori pembayaran berdasarkan no_bukti",
     *     @OA\Parameter(
     *         name="no_bukti",
     *         in="query",
     *         required=true,
     *         @OA\Schema(type="string"),
     *         description="Nomor bukti pembayaran"
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Berhasil ambil detail histori pembayaran",
     *         @OA\JsonContent(type="array", @OA\Items(type="object"))
     *     )
     * )
     */
    public function getDetailHistoribayar(Request $request)
    {
        $no_bukti = $request->no_bukti;
        $historibayar = Detailhistoribayarpendidikan::where('pendidikan_historibayar_detail.no_bukti', $no_bukti)
            ->select(
                'pendidikan_historibayar_detail.no_bukti',
                'tanggal',
                'name',
                'pendidikan_historibayar_detail.kode_jenis_biaya',
                'jenis_biaya',
                'konfigurasi_biaya.tingkat',
                'tahun_ajaran',
                'jumlah',
                'keterangan'
            )
            ->join('pendidikan_historibayar', 'pendidikan_historibayar_detail.no_bukti', '=', 'pendidikan_historibayar.no_bukti')
            ->join('pendaftaran', 'pendidikan_historibayar.no_pendaftaran', '=', 'pendaftaran.no_pendaftaran')
            ->join('users', 'pendidikan_historibayar.id_user', '=', 'users.id')
            ->join('konfigurasi_biaya', 'konfigurasi_biaya.kode_biaya', '=', 'pendidikan_historibayar_detail.kode_biaya')
            ->join('konfigurasi_tahunajaran_ppdb', 'konfigurasi_tahunajaran_ppdb.kode_ta', '=', 'konfigurasi_biaya.kode_ta')
            ->join('jenis_biaya', 'jenis_biaya.kode_jenis_biaya', '=', 'pendidikan_historibayar_detail.kode_jenis_biaya')
            ->where('pendidikan_historibayar_detail.no_bukti', $no_bukti)
            ->get();
        return response()->json($historibayar);
    }
}
