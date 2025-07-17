<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Biayasiswa;
use App\Models\Kelassiswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Siswa;
use App\Models\Tahunajaran;

class SiswaController extends Controller
{
    /**
     * @OA\Get(
     *     path="/siswa-anak",
     *     tags={"Siswa"},
     *     summary="Ambil data siswa berdasarkan nik ayah/ibu user login",
     *     security={{"sanctum":{}}},
     *     @OA\Response(
     *         response=200,
     *         description="Berhasil ambil data siswa",
     *         @OA\JsonContent(type="array", @OA\Items(type="object"))
     *     )
     * )
     */
    /**
     * API: Get siswa by nik_ayah or nik_ibu matching logged in user's username
     * @return \Illuminate\Http\JsonResponse
     */
    public function anakByNikOrtu()
    {
        $nik = Auth::user()->username;


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
        $query->join('konfigurasi_tahun_ajaran', 'konfigurasi_biaya.kode_ta', 'konfigurasi_tahun_ajaran.kode_ta');
        $query->leftJoinSub($kelas_siswa, 'kelas_siswa', function ($join) {
            $join->on('kelas_siswa.id_siswa', '=', 'pendaftaran.id_siswa');
        });
        $query->where('konfigurasi_biaya.kode_ta', $ta_aktif->kode_ta);
       


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
                'siswa_biaya.logo'
            )
            ->where('siswa.nik_ayah', $nik)
            ->orWhere('siswa.nik_ibu',$nik)
            ->get();
        return response()->json($siswa);
    }
}
