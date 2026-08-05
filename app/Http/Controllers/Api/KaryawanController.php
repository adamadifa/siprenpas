<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Karyawan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

/**
 * @OA\Tag(
 *     name="Karyawan",
 *     description="Manajemen Karyawan"
 * )
 */
class KaryawanController extends Controller
{
    /**
     * @OA\Get(
     *     path="/karyawan/aktif",
     *     tags={"Karyawan"},
     *     summary="Ambil daftar karyawan aktif",
     *     @OA\Parameter(
     *         name="nama",
     *         in="query",
     *         description="Filter berdasarkan nama karyawan (partial match)",
     *         required=false,
     *         @OA\Schema(type="string", example="John")
     *     ),
     *     @OA\Parameter(
     *         name="unit",
     *         in="query",
     *         description="Filter berdasarkan kode unit",
     *         required=false,
     *         @OA\Schema(type="string", example="U01")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Berhasil ambil daftar karyawan aktif",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="success",
     *                 type="boolean",
     *                 example=true
     *             ),
     *             @OA\Property(
     *                 property="data",
     *                 type="array",
     *                 @OA\Items(
     *                     type="object",
                     *                     @OA\Property(property="npp", type="string", example="K001"),
                     *                     @OA\Property(property="nama", type="string", example="John Doe"),
                     *                     @OA\Property(property="jabatan", type="string", example="Guru"),
                     *                     @OA\Property(property="nama_unit", type="string", example="SMP"),
                     *                     @OA\Property(property="foto", type="string", example="http://example.com/storage/photos/karyawan/photo.jpg")
     *                 )
     *             )
     *         )
     *     )
     * )
     */
    public function getAktif(Request $request)
    {
        try {
            $query = Karyawan::select(
                'karyawan.npp',
                'karyawan.nama_lengkap as nama',
                'jabatan.nama_jabatan as jabatan',
                'unit.nama_unit',
                'karyawan.kode_unit',
                'karyawan.foto'
            )
                ->join('jabatan', 'karyawan.kode_jabatan', '=', 'jabatan.kode_jabatan')
                ->join('unit', 'karyawan.kode_unit', '=', 'unit.kode_unit')
                ->where('karyawan.status', 1);

            // Filter berdasarkan nama (partial match)
            if ($request->has('nama') && !empty($request->nama)) {
                $query->where('karyawan.nama_lengkap', 'like', '%' . $request->nama . '%');
            }

            // Filter berdasarkan unit
            if ($request->has('unit') && !empty($request->unit)) {
                $query->where('karyawan.kode_unit', $request->unit);
            }

            $karyawan = $query->orderBy('karyawan.nama_lengkap', 'asc')
                ->get()
                ->map(function ($item) {
                    // Gunakan helper function untuk mendapatkan URL foto atau default image
                    $fotoUrl = null;
                    if (!empty($item->foto)) {
                        $fotoUrl = url('/storage/photos/karyawan/' . $item->foto);
                    } else {
                        $fotoUrl = asset('assets/img/avatars/No_Image_Available.jpg');
                    }

                    return [
                        'npp' => $item->npp,
                        'nama' => $item->nama,
                        'jabatan' => $item->jabatan,
                        'nama_unit' => $item->nama_unit,
                        'foto' => $fotoUrl
                    ];
                });

            return response()->json([
                'success' => true,
                'data' => $karyawan
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat mengambil data karyawan.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function getGuruDashboard(Request $request)
    {
        try {
            $user = $request->user();
            
            // Resolve NPP
            $npp = $user->npp;
            if (empty($npp)) {
                $userKaryawan = \App\Models\Userkaryawan::where('id_user', $user->id)->first();
                if ($userKaryawan) {
                    $npp = $userKaryawan->npp;
                } else {
                    $npp = $user->username;
                }
            }

            $guru = \App\Models\Guru::with('karyawan')->where('npp', $npp)->first();

            if (!$guru) {
                return response()->json([
                    'success' => false,
                    'message' => 'Anda tidak terdaftar sebagai guru.'
                ], 404);
            }

            $activeTa = \App\Models\Tahunajaran::where('status', '1')->first();
            $activeSemester = \App\Models\Semester::where('status', '1')->first();
            $selectedSemester = $activeSemester ? $activeSemester->semester : '1';

            $hariIni = getHari(date('Y-m-d'));

            $jadwalHariIni = collect();
            if ($activeTa) {
                $jadwalHariIni = \App\Models\JadwalPelajaran::with(['mapel', 'kelas'])
                    ->where('guru_id', $guru->id)
                    ->where('kode_ta', $activeTa->kode_ta)
                    ->where('semester', $selectedSemester)
                    ->where('hari', $hariIni)
                    ->orderBy('jam_ke')
                    ->get()
                    ->map(function ($j) {
                        $sudah_presensi = DB::table('presensi_mapel')
                            ->where('jadwal_pelajaran_id', $j->id)
                            ->where('tanggal', date('Y-m-d'))
                            ->exists();
                        return [
                            'id' => $j->id,
                            'jam_ke' => $j->jam_ke,
                            'jam_mulai' => $j->jam_mulai,
                            'jam_selesai' => $j->jam_selesai,
                            'nama_mapel' => $j->mapel->nama_matpel ?? '-',
                            'nama_kelas' => $j->kelas->nama_kelas ?? '-',
                            'sudah_presensi' => $sudah_presensi
                        ];
                    });
            }

            $listKelasBinaan = collect();
            $kelasBinaan = null;
            $listKelasBinaanData = [];
            if ($activeTa) {
                $listKelasBinaan = \App\Models\Kelas::with('unit')
                    ->where('guru_id', $guru->id)
                    ->where('kode_ta', $activeTa->kode_ta)
                    ->get();

                foreach ($listKelasBinaan as $kb) {
                    $totalSiswa = \App\Models\Kelassiswa::where('kode_kelas', $kb->kode_kelas)->count();
                    $listKelasBinaanData[] = [
                        'nama_kelas' => $kb->nama_kelas,
                        'nama_unit' => $kb->unit->nama_unit ?? '-',
                        'total_siswa' => $totalSiswa
                    ];
                }
            }

            return response()->json([
                'success' => true,
                'data' => [
                    'guru' => [
                        'npp' => $guru->npp,
                        'nama' => $guru->karyawan->nama_lengkap ?? '-',
                        'nama_unit' => $guru->unit->nama_unit ?? '-',
                        'foto' => $guru->karyawan->foto ? url('/storage/photos/karyawan/' . $guru->karyawan->foto) : null,
                    ],
                    'tahun_ajaran' => $activeTa ? $activeTa->tahun_ajaran : '-',
                    'semester' => $selectedSemester,
                    'hari_ini' => $hariIni,
                    'jadwal_hari_ini' => $jadwalHariIni,
                    'kelas_binaan' => !empty($listKelasBinaanData) ? $listKelasBinaanData : null
                ]
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function getPresensiMapelInput(Request $request, $jadwal_id, $tanggal = null)
    {
        try {
            $tanggal = $tanggal ?: date('Y-m-d');
            $user = $request->user();
            
            // Resolve NPP
            $npp = $user->npp;
            if (empty($npp)) {
                $userKaryawan = \App\Models\Userkaryawan::where('id_user', $user->id)->first();
                if ($userKaryawan) {
                    $npp = $userKaryawan->npp;
                } else {
                    $npp = $user->username;
                }
            }

            $guru = \App\Models\Guru::where('npp', $npp)->first();
            if (!$guru) {
                return response()->json([
                    'success' => false,
                    'message' => 'Anda tidak terdaftar sebagai guru.'
                ], 403);
            }

            $jadwal = \App\Models\JadwalPelajaran::with(['mapel', 'kelas'])->findOrFail($jadwal_id);

            if ($jadwal->guru_id != $guru->id) {
                return response()->json([
                    'success' => false,
                    'message' => 'Akses ditolak. Jadwal ini bukan milik Anda.'
                ], 403);
            }

            // Check if already exists
            $presensi = \App\Models\PresensiMapel::with(['details.siswa.pendaftaran'])
                ->where('jadwal_pelajaran_id', $jadwal_id)
                ->where('tanggal', $tanggal)
                ->first();

            $students = [];
            $materi = '';
            $presensi_id = null;

            if ($presensi) {
                $presensi_id = $presensi->id;
                $materi = $presensi->materi;
                // Sort details alphabetically by student name
                $detailsSorted = $presensi->details->sortBy(function($detail) {
                    return $detail->siswa->nama_lengkap ?? '';
                });

                foreach ($detailsSorted as $detail) {
                    if (!$detail->siswa) continue;
                    $fotoUrl = null;
                    if ($detail->siswa->pendaftaran && !empty($detail->siswa->pendaftaran->foto)) {
                        $fotoUrl = url('/storage/photos/pendaftaran/' . $detail->siswa->pendaftaran->foto);
                    }
                    $students[] = [
                        'siswa_id' => $detail->siswa_id,
                        'nama_lengkap' => $detail->siswa->nama_lengkap ?? '-',
                        'no_pendaftaran' => $detail->siswa->pendaftaran->no_pendaftaran ?? '-',
                        'foto' => $fotoUrl,
                        'status' => $detail->status, // H, I, S, A
                        'keterangan' => $detail->keterangan
                    ];
                }
            } else {
                // Get students in this class ordered alphabetically
                $studentsList = DB::table('kelas_siswa')
                    ->join('siswa', 'kelas_siswa.id_siswa', '=', 'siswa.id_siswa')
                    ->leftJoin('pendaftaran', 'siswa.id_siswa', '=', 'pendaftaran.id_siswa')
                    ->where('kelas_siswa.kode_kelas', $jadwal->kode_kelas)
                    ->select('pendaftaran.no_pendaftaran', 'pendaftaran.foto', 'siswa.id_siswa as siswa_id', 'siswa.nama_lengkap')
                    ->orderBy('siswa.nama_lengkap', 'asc')
                    ->get();

                foreach ($studentsList as $s) {
                    $fotoUrl = null;
                    if (!empty($s->foto)) {
                        $fotoUrl = url('/storage/photos/pendaftaran/' . $s->foto);
                    }
                    $students[] = [
                        'siswa_id' => $s->siswa_id,
                        'nama_lengkap' => $s->nama_lengkap,
                        'no_pendaftaran' => $s->no_pendaftaran ?? '-',
                        'foto' => $fotoUrl,
                        'status' => 'H', // Default to Present (Hadir)
                        'keterangan' => ''
                    ];
                }
            }

            return response()->json([
                'success' => true,
                'data' => [
                    'presensi_id' => $presensi_id,
                    'materi' => $materi,
                    'tanggal' => $tanggal,
                    'jadwal' => [
                        'id' => $jadwal->id,
                        'nama_mapel' => $jadwal->mapel->nama_matpel ?? '-',
                        'nama_kelas' => $jadwal->kelas->nama_kelas ?? '-',
                        'jam_ke' => $jadwal->jam_ke,
                        'jam_mulai' => $jadwal->jam_mulai,
                        'jam_selesai' => $jadwal->jam_selesai,
                    ],
                    'students' => $students
                ]
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function storePresensiMapel(Request $request)
    {
        \Illuminate\Support\Facades\Log::info('storePresensiMapel hit:', $request->all());
        $request->validate([
            'jadwal_pelajaran_id' => 'required',
            'tanggal' => 'required',
            'status' => 'required|array',
            'materi' => 'nullable|string'
        ]);

        $user = $request->user();
        
        // Resolve NPP
        $npp = $user->npp;
        if (empty($npp)) {
            $userKaryawan = \App\Models\Userkaryawan::where('id_user', $user->id)->first();
            if ($userKaryawan) {
                $npp = $userKaryawan->npp;
            } else {
                $npp = $user->username;
            }
        }

        $guru = \App\Models\Guru::where('npp', $npp)->first();
        if (!$guru) {
            return response()->json([
                'success' => false,
                'message' => 'Anda tidak terdaftar sebagai guru.'
            ], 403);
        }

        $jadwal = \App\Models\JadwalPelajaran::findOrFail($request->jadwal_pelajaran_id);

        if ($jadwal->guru_id != $guru->id) {
            return response()->json([
                'success' => false,
                'message' => 'Akses ditolak. Jadwal ini bukan milik Anda.'
            ], 403);
        }

        DB::beginTransaction();
        try {
            // Check if already exists
            $presensi = \App\Models\PresensiMapel::where('jadwal_pelajaran_id', $jadwal->id)
                ->where('tanggal', $request->tanggal)
                ->first();

            if ($presensi) {
                // Update
                $presensi->update([
                    'materi' => $request->materi
                ]);

                foreach ($request->status as $siswa_id => $status) {
                    \App\Models\PresensiMapelDetail::updateOrCreate(
                        [
                            'presensi_mapel_id' => $presensi->id,
                            'siswa_id' => $siswa_id
                        ],
                        [
                            'status' => $status,
                            'keterangan' => $request->keterangan[$siswa_id] ?? null
                        ]
                    );
                }
            } else {
                // Create
                $presensi = \App\Models\PresensiMapel::create([
                    'jadwal_pelajaran_id' => $jadwal->id,
                    'kode_unit' => $jadwal->kode_unit,
                    'kode_kelas' => $jadwal->kode_kelas,
                    'mata_pelajaran_id' => $jadwal->mata_pelajaran_id,
                    'guru_id' => $jadwal->guru_id,
                    'tanggal' => $request->tanggal,
                    'jam_mulai' => $jadwal->jam_mulai,
                    'jam_selesai' => $jadwal->jam_selesai,
                    'materi' => $request->materi,
                    'status_pertemuan' => 1
                ]);

                foreach ($request->status as $siswa_id => $status) {
                    \App\Models\PresensiMapelDetail::create([
                        'presensi_mapel_id' => $presensi->id,
                        'siswa_id' => $siswa_id,
                        'status' => $status,
                        'keterangan' => $request->keterangan[$siswa_id] ?? null
                    ]);
                }
            }

            DB::commit();
            return response()->json([
                'success' => true,
                'message' => 'Presensi berhasil disimpan.'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function getPresensiMapelHistory(Request $request)
    {
        try {
            $user = $request->user();
            
            // Resolve NPP
            $npp = $user->npp;
            if (empty($npp)) {
                $userKaryawan = \App\Models\Userkaryawan::where('id_user', $user->id)->first();
                if ($userKaryawan) {
                    $npp = $userKaryawan->npp;
                } else {
                    $npp = $user->username;
                }
            }

            $guru = \App\Models\Guru::where('npp', $npp)->first();

            if (!$guru) {
                return response()->json([
                    'success' => false,
                    'message' => 'Anda tidak terdaftar sebagai guru.'
                ], 404);
            }

            $query = \App\Models\PresensiMapel::query()
                ->where('guru_id', $guru->id);

            if ($request->tanggal) {
                $query->where('tanggal', $request->tanggal);
            }

            if ($request->kode_unit) {
                $query->where('kode_unit', $request->kode_unit);
            }

            if ($request->kode_kelas) {
                $query->where('kode_kelas', $request->kode_kelas);
            }

            $presensi = $query->with(['unit', 'kelas', 'mata_pelajaran'])
                ->orderBy('tanggal', 'desc')
                ->orderBy('created_at', 'desc')
                ->get()
                ->map(function($p) {
                    return [
                        'id' => $p->id,
                        'jadwal_pelajaran_id' => $p->jadwal_pelajaran_id,
                        'tanggal' => $p->tanggal,
                        'jam_mulai' => $p->jam_mulai,
                        'jam_selesai' => $p->jam_selesai,
                        'materi' => $p->materi,
                        'nama_kelas' => $p->kelas->nama_kelas ?? '-',
                        'nama_unit' => $p->unit->nama_unit ?? '-',
                        'nama_mapel' => $p->mata_pelajaran->nama_matpel ?? '-',
                    ];
                });

            return response()->json([
                'success' => true,
                'data' => $presensi
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function getGuruJadwal(Request $request)
    {
        try {
            $user = $request->user();
            
            // Resolve NPP
            $npp = $user->npp;
            if (empty($npp)) {
                $userKaryawan = \App\Models\Userkaryawan::where('id_user', $user->id)->first();
                if ($userKaryawan) {
                    $npp = $userKaryawan->npp;
                } else {
                    $npp = $user->username;
                }
            }

            $guru = \App\Models\Guru::where('npp', $npp)->first();

            if (!$guru) {
                return response()->json([
                    'success' => false,
                    'message' => 'Anda tidak terdaftar sebagai guru.'
                ], 404);
            }

            $query = \App\Models\JadwalPelajaran::with(['mapel', 'kelas', 'unit', 'tahunAjaran'])
                ->where('guru_id', $guru->id);

            // Filter options
            if ($request->kode_unit) {
                $query->where('kode_unit', $request->kode_unit);
            }

            if ($request->kode_kelas) {
                $query->where('kode_kelas', $request->kode_kelas);
            }

            if ($request->semester) {
                $query->where('semester', $request->semester);
            }

            $jadwal = $query->orderBy('hari', 'asc')
                ->orderBy('jam_ke', 'asc')
                ->get();

            $data = [];
            foreach ($jadwal as $j) {
                $data[] = [
                    'id' => $j->id,
                    'hari' => $j->hari,
                    'jam_ke' => $j->jam_ke,
                    'jam_mulai' => $j->jam_mulai,
                    'jam_selesai' => $j->jam_selesai,
                    'semester' => $j->semester,
                    'nama_mapel' => $j->mapel->nama_matpel ?? '-',
                    'nama_kelas' => $j->kelas->nama_kelas ?? '-',
                    'nama_unit' => $j->unit->nama_unit ?? '-',
                    'kode_unit' => $j->kode_unit,
                    'kode_kelas' => $j->kode_kelas,
                    'tahun_ajaran' => $j->tahunAjaran->tahun_ajaran ?? '-',
                ];
            }

            return response()->json([
                'success' => true,
                'data' => $data
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }
}

