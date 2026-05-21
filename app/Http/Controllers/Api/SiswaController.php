<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Biayasiswa;
use App\Models\Kelassiswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Siswa;
use App\Models\Tahunajaran;
use Illuminate\Support\Facades\DB;

class SiswaController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/siswa-anak",
     *     tags={"Siswa"},
     *     summary="Ambil data siswa berdasarkan nik ayah/ibu user login",
     *     security={{"sanctum":{}}},
     *     @OA\Response(
     *         response=200,
     *         description="Berhasil ambil data siswa",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(
     *                 type="object",
     *                 example={
     *                     "id_siswa": 1,
     *                     "nik": "1234567890123456",
     *                     "nis": "2023001",
     *                     "nama_lengkap": "Ahmad Fulan",
     *                     "jenis_kelamin": "L",
     *                     "tempat_lahir": "Jakarta",
     *                     "tanggal_lahir": "2015-05-20",
     *                     "alamat": "Jl. Mawar No. 10",
     *                     "no_hp": "08123456789",
     *                     "email": "siswa@example.com",
     *                     "foto": "siswa.jpg",
     *                     "status": "Aktif",
     *                     "no_pendaftaran": "REG2023001",
     *                     "tahun_ajaran": "2023/2024",
     *                     "nama_kelas": "1A",
     *                     "tingkat": "SD",
     *                     "nama_unit": "SD Al Amin",
     *                     "logo": "logo.png"
     *                 }
     *             )
     *         )
     *     )
     * )
     * API: Get siswa by nik_ayah or nik_ibu matching logged in user's username
     * @return \Illuminate\Http\JsonResponse
     */
    public function anakByNikOrtu()
    {
        $nik = Auth::user()->username;


        $ta_aktif = Tahunajaran::where('status', 1)->first();
        $kode_ta_aktif = $ta_aktif ? $ta_aktif->kode_ta : '';

        $kelas_siswa = Kelassiswa::join('kelas', 'kelas_siswa.kode_kelas', 'kelas.kode_kelas')
            ->select('kelas_siswa.id_siswa', 'nama_kelas');
        if ($kode_ta_aktif) {
            $kelas_siswa->where('kelas.kode_ta', $kode_ta_aktif);
        }
        $query = Biayasiswa::query();
        $query->select(
            'pendaftaran.id_siswa',
            'pendaftaran.no_pendaftaran',
            'tahun_ajaran',
            'pendaftaran.nis',
            'pendaftaran.foto',
            'kelas_siswa.nama_kelas',
            'konfigurasi_biaya.tingkat',
            'nama_unit',
            'logo'
        );
        $query->join('pendaftaran', 'siswa_biaya.no_pendaftaran', 'pendaftaran.no_pendaftaran');
        $query->join('unit', 'pendaftaran.kode_unit', 'unit.kode_unit');
        $query->join('konfigurasi_biaya', 'siswa_biaya.kode_biaya', 'konfigurasi_biaya.kode_biaya');
        $query->where('konfigurasi_biaya.is_pindahan', 0);
        $query->leftjoin('asal_sekolah', 'pendaftaran.kode_asal_sekolah', 'asal_sekolah.kode_asal_sekolah');
        $query->join('konfigurasi_tahun_ajaran', 'konfigurasi_biaya.kode_ta', 'konfigurasi_tahun_ajaran.kode_ta');
        $query->leftJoinSub($kelas_siswa, 'kelas_siswa', function ($join) {
            $join->on('kelas_siswa.id_siswa', '=', 'pendaftaran.id_siswa');
        });
        if ($ta_aktif) {
            $query->where('konfigurasi_biaya.kode_ta', $ta_aktif->kode_ta);
        }
       


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
                DB::raw('(SELECT foto FROM pendaftaran WHERE pendaftaran.id_siswa = siswa.id_siswa ORDER BY created_at DESC LIMIT 1) as foto_pendaftaran')
            )
            ->where('siswa.nik_ayah', $nik)
            ->orWhere('siswa.nik_ibu', $nik)
            ->get();

        // Format foto URL
        $siswa->transform(function ($item) {
            // Priority: foto from pendaftaran
            $foto = $item->foto_pendaftaran ?: $item->foto; 
            
            if ($foto) {
                $item->foto = asset('storage/photos/pendaftaran/' . $foto);
            }
            return $item;
        });

        return response()->json($siswa);
    }
}
