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

    public function getCheckinStatus(Request $request)
    {
        try {
            $user = $request->user();
            $userkaryawan = \App\Models\Userkaryawan::where('id_user', $user->id)->first();
            if (!$userkaryawan) {
                return response()->json(['success' => false, 'message' => 'Hubungan user karyawan tidak ditemukan'], 400);
            }
            $karyawan = \App\Models\Karyawan::where('npp', $userkaryawan->npp)->first();
            if (!$karyawan) {
                return response()->json(['success' => false, 'message' => 'Data karyawan tidak ditemukan'], 400);
            }

            // Get Cabang Lokasi
            $cabang = \App\Models\Cabang::where('kode_cabang', 'PST')->first();

            // Cek Lintas Hari
            $hariini = date("Y-m-d");
            $jamsekarang = date("H:i");
            $tgl_sebelumnya = date('Y-m-d', strtotime("-1 days", strtotime($hariini)));
            
            $cekpresensi_sebelumnya = \App\Models\Presensi::join('konfigurasi_jam_kerja', 'presensi.kode_jam_kerja', '=', 'konfigurasi_jam_kerja.kode_jam_kerja')
                ->where('tanggal', $tgl_sebelumnya)
                ->where('npp', $karyawan->npp)
                ->first();

            $ceklintashari_presensi = $cekpresensi_sebelumnya != null ? $cekpresensi_sebelumnya->lintashari : 0;
            if ($ceklintashari_presensi == 1) {
                if ($jamsekarang < "08:00") {
                    $hariini = $tgl_sebelumnya;
                }
            }

            $namahari = getnamaHari(date('D', strtotime($hariini)));

            // Cek Presensi
            $presensi = \App\Models\Presensi::where('npp', $karyawan->npp)->where('tanggal', $hariini)->first();

            // Cek Jam Kerja
            $jamkerja = \App\Models\Setjamkerjabydate::join('konfigurasi_jam_kerja', 'presensi_jamkerja_bydate.kode_jam_kerja', '=', 'konfigurasi_jam_kerja.kode_jam_kerja')
                ->where('npp', $karyawan->npp)
                ->where('tanggal', $hariini)
                ->first();

            if ($jamkerja == null) {
                $jamkerja = \App\Models\Setjamkerjabyday::join('konfigurasi_jam_kerja', 'presensi_jamkerja_byday.kode_jam_kerja', '=', 'konfigurasi_jam_kerja.kode_jam_kerja')
                    ->where('npp', $karyawan->npp)->where('hari', $namahari)->first();

                if ($jamkerja == null) {
                    $jamkerja = \App\Models\Jamkerja::where('kode_jam_kerja', 'JK01')->first();
                }
            }

            return response()->json([
                'success' => true,
                'data' => [
                    'hariini' => $hariini,
                    'jam_kerja' => $jamkerja,
                    'lokasi_kantor' => $cabang,
                    'presensi' => $presensi,
                    'lock_location' => $karyawan->lock_location
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function storeEmployeePresensi(Request $request)
    {
        try {
            $user = $request->user();
            $userkaryawan = \App\Models\Userkaryawan::where('id_user', $user->id)->first();
            if (!$userkaryawan) {
                return response()->json(['success' => false, 'message' => 'Hubungan user karyawan tidak ditemukan'], 400);
            }
            $karyawan = \App\Models\Karyawan::where('npp', $userkaryawan->npp)->first();
            if (!$karyawan) {
                return response()->json(['success' => false, 'message' => 'Data karyawan tidak ditemukan'], 400);
            }

            $status_lock_location = $karyawan->lock_location;
            $status = $request->status; // 1: In, 2: Out
            $lokasi = $request->lokasi; // "lat,lng"
            $kode_jam_kerja = $request->kode_jam_kerja;
            $image = $request->image; // base64 image data url

            if (empty($lokasi)) {
                return response()->json(['success' => false, 'message' => 'Lokasi GPS wajib dikirim'], 400);
            }
            if (empty($image)) {
                return response()->json(['success' => false, 'message' => 'Foto presensi wajib diambil'], 400);
            }

            $tanggal_sekarang = date("Y-m-d");
            $jam_sekarang = date("H:i");

            $tanggal_kemarin = date("Y-m-d", strtotime("-1 days"));
            $tanggal_besok = date("Y-m-d", strtotime("+1 days"));

            // Cek Presensi Kemarin
            $presensi_kemarin = \App\Models\Presensi::where('npp', $karyawan->npp)
                ->join('konfigurasi_jam_kerja', 'presensi.kode_jam_kerja', '=', 'konfigurasi_jam_kerja.kode_jam_kerja')
                ->where('tanggal', $tanggal_kemarin)->first();

            $lintas_hari = $presensi_kemarin ? $presensi_kemarin->lintashari : 0;
            $tanggal_presensi = $lintas_hari == 1 ? $tanggal_kemarin : $tanggal_sekarang;

            // Get Lokasi User
            $koordinat_user = explode(",", $lokasi);
            $latitude_user = $koordinat_user[0];
            $longitude_user = $koordinat_user[1];

            // Get Lokasi Kantor
            $cabang = \App\Models\Cabang::where('kode_cabang', 'PST')->first();
            $lokasi_kantor = $cabang->lokasi_cabang;
            $koordinat_kantor = explode(",", $lokasi_kantor);
            $latitude_kantor = $koordinat_kantor[0];
            $longitude_kantor = $koordinat_kantor[1];

            $jarak = hitungjarak($latitude_kantor, $longitude_kantor, $latitude_user, $longitude_user);
            $radius = round($jarak["meters"]);

            $tanggal_pulang = $lintas_hari == 1 ? $tanggal_besok : $tanggal_sekarang;
            $in_out = $status == 1 ? "in" : "out";
            
            $folderPath = "public/uploads/absensi/";
            $formatName = $karyawan->npp . "-" . $tanggal_presensi . "-" . $in_out;
            
            // Handle base64 image data
            $image_parts = explode(";base64,", $image);
            if (count($image_parts) < 2) {
                // Try split by semicolon
                $image_parts = explode(";base64", $image);
            }
            $image_base64 = base64_decode($image_parts[1]);
            $fileName = $formatName . ".png";
            $file = $folderPath . $fileName;

            $jam_kerja = \App\Models\Jamkerja::where('kode_jam_kerja', $kode_jam_kerja)->first();
            $jam_presensi = $tanggal_sekarang . " " . date("H:i:s");

            $presensi_hariini = \App\Models\Presensi::where('npp', $karyawan->npp)
                ->where('tanggal', $tanggal_presensi)
                ->first();

            if ($status_lock_location == 1 && $radius > $cabang->radius_cabang) {
                return response()->json([
                    'success' => false,
                    'message' => 'Anda Berada Di Luar Radius Kantor. Jarak Anda ' . $radius . ' meter dari kantor.'
                ], 400);
            }

            if ($status == 1) {
                if ($presensi_hariini && $presensi_hariini->jam_in != null) {
                    return response()->json(['success' => false, 'message' => 'Anda Sudah Absen Masuk Hari Ini'], 400);
                }
                
                if ($presensi_hariini != null) {
                    \App\Models\Presensi::where('id', $presensi_hariini->id)->update([
                        'jam_in' => $jam_presensi,
                        'lokasi_in' => $lokasi,
                        'foto_in' => $fileName
                    ]);
                } else {
                    \App\Models\Presensi::create([
                        'npp' => $karyawan->npp,
                        'tanggal' => $tanggal_presensi,
                        'jam_in' => $jam_presensi,
                        'jam_out' => null,
                        'lokasi_in' => $lokasi,
                        'lokasi_out' => null,
                        'foto_in' => $fileName,
                        'foto_out' => null,
                        'kode_jam_kerja' => $kode_jam_kerja,
                        'status' => 'h'
                    ]);
                }
            } else {
                if ($presensi_hariini && $presensi_hariini->jam_out != null) {
                    return response()->json(['success' => false, 'message' => 'Anda Sudah Absen Pulang Hari Ini'], 400);
                }
                
                if ($presensi_hariini != null) {
                    \App\Models\Presensi::where('id', $presensi_hariini->id)->update([
                        'jam_out' => $jam_presensi,
                        'lokasi_out' => $lokasi,
                        'foto_out' => $fileName
                    ]);
                } else {
                    \App\Models\Presensi::create([
                        'npp' => $karyawan->npp,
                        'tanggal' => $tanggal_presensi,
                        'jam_in' => null,
                        'jam_out' => $jam_presensi,
                        'lokasi_in' => null,
                        'lokasi_out' => $lokasi,
                        'foto_in' => null,
                        'foto_out' => $fileName,
                        'kode_jam_kerja' => $kode_jam_kerja,
                        'status' => 'h'
                    ]);
                }
            }

            \Illuminate\Support\Facades\Storage::put($file, $image_base64);

            return response()->json([
                'success' => true,
                'message' => $status == 1 ? 'Berhasil Absen Masuk' : 'Berhasil Absen Pulang'
            ]);

        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function deleteTodayPresensi(Request $request)
    {
        try {
            $user = $request->user();
            $userkaryawan = \App\Models\Userkaryawan::where('id_user', $user->id)->first();
            if (!$userkaryawan) {
                return response()->json(['success' => false, 'message' => 'Hubungan user karyawan tidak ditemukan'], 400);
            }
            
            $today = date('Y-m-d');
            $presensi = \App\Models\Presensi::where('npp', $userkaryawan->npp)
                ->where('tanggal', $today)
                ->first();
                
            if (!$presensi) {
                return response()->json(['success' => false, 'message' => 'Data presensi hari ini tidak ditemukan'], 404);
            }
            
            // Delete photos from storage if they exist
            if ($presensi->foto_in) {
                \Illuminate\Support\Facades\Storage::delete('public/uploads/absensi/' . $presensi->foto_in);
            }
            if ($presensi->foto_out) {
                \Illuminate\Support\Facades\Storage::delete('public/uploads/absensi/' . $presensi->foto_out);
            }
            
            $presensi->delete();
            
            return response()->json([
                'success' => true,
                'message' => 'Berhasil menghapus data presensi hari ini'
            ]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }
}
