<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\BobotPenilaian;
use App\Models\JadwalPelajaran;
use App\Models\Kelassiswa;
use App\Models\NilaiSiswa;
use App\Models\RencanaPenilaian;
use App\Models\Guru;
use App\Models\Kelas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class PenilaianApiController extends Controller
{
    public function index($jadwal_id)
    {
        try {
            $jadwal = JadwalPelajaran::with(['kelas', 'mapel', 'guru', 'tahunAjaran'])->findOrFail($jadwal_id);

            // Authorize
            $user = auth()->user();
            if (!$user->can('jadwalpelajaran.index') && !$user->hasRole('guru')) {
                return response()->json(['success' => false, 'message' => 'Akses ditolak.'], 403);
            }

            if ($user->hasRole('guru') && !$user->can('jadwalpelajaran.index')) {
                $guru = Guru::where('npp', $user->npp)->first();
                if (!$guru) {
                    return response()->json(['success' => false, 'message' => 'Data guru tidak ditemukan.'], 403);
                }
                $isWaliKelas = Kelas::where('kode_kelas', $jadwal->kode_kelas)
                    ->where('guru_id', $guru->id)
                    ->exists();
                if ($jadwal->guru_id !== $guru->id && !$isWaliKelas) {
                    return response()->json(['success' => false, 'message' => 'Akses ditolak. Anda hanya dapat mengakses kelas bimbingan atau kelas Anda sendiri.'], 403);
                }
            }

            $bobot = BobotPenilaian::firstOrCreate(
                [
                    'kode_kelas' => $jadwal->kode_kelas,
                    'mata_pelajaran_id' => $jadwal->mata_pelajaran_id,
                    'kode_ta' => $jadwal->kode_ta,
                    'semester' => $jadwal->semester,
                ],
                [
                    'guru_id' => $jadwal->guru_id,
                    'bobot_sumatif' => 60,
                    'bobot_sas' => 40,
                    'status' => 'draft'
                ]
            );

            $rencanaPenilaian = RencanaPenilaian::where('bobot_penilaian_id', $bobot->id)
                ->orderBy('created_at')
                ->get();

            // Get all students
            $students = Kelassiswa::where('kode_kelas', $bobot->kode_kelas)
                ->join('siswa', 'kelas_siswa.id_siswa', '=', 'siswa.id_siswa')
                ->leftJoin('pendaftaran', 'siswa.id_siswa', '=', 'pendaftaran.id_siswa')
                ->orderBy('siswa.nama_lengkap')
                ->select('siswa.id_siswa', 'pendaftaran.nis', 'siswa.nama_lengkap', 'pendaftaran.foto')
                ->get();

            // Fetch grades
            $grades = NilaiSiswa::whereIn('rencana_penilaian_id', $rencanaPenilaian->pluck('id'))
                ->get()
                ->groupBy('id_siswa');

            // Calculate averages
            $studentsData = $students->map(function ($student) use ($grades, $rencanaPenilaian, $bobot) {
                $student_grades = $grades->get($student->id_siswa, collect());

                // Sumatif
                $sumatif_ids = $rencanaPenilaian->where('kategori_penilaian', 'SUMATIF')->pluck('id');
                $sumatif_scores = $student_grades->whereIn('rencana_penilaian_id', $sumatif_ids)->pluck('nilai');
                $avg_sumatif = $sumatif_scores->count() > 0 ? $sumatif_scores->avg() : 0;

                // SAS
                $sas_ids = $rencanaPenilaian->where('kategori_penilaian', 'SAS')->pluck('id');
                $sas_scores = $student_grades->whereIn('rencana_penilaian_id', $sas_ids)->pluck('nilai');
                $nilai_sas = $sas_scores->count() > 0 ? $sas_scores->avg() : 0;

                // Final Calculation
                $nilai_rapor = ($avg_sumatif * ($bobot->bobot_sumatif / 100)) + ($nilai_sas * ($bobot->bobot_sas / 100));

                return [
                    'id_siswa' => $student->id_siswa,
                    'nis' => $student->nis ?? '-',
                    'nama_lengkap' => $student->nama_lengkap,
                    'foto' => $student->foto,
                    'rata_sumatif' => round($avg_sumatif),
                    'nilai_sas' => round($nilai_sas),
                    'nilai_rapor' => round($nilai_rapor),
                    'capaian_kompetensi' => $nilai_rapor >= 75 ? "Menunjukkan penguasaan yang baik." : "Perlu bimbingan lebih lanjut."
                ];
            });

            return response()->json([
                'success' => true,
                'data' => [
                    'jadwal' => [
                        'id' => $jadwal->id,
                        'nama_mapel' => $jadwal->mapel->nama_matpel ?? '-',
                        'nama_kelas' => $jadwal->kelas->nama_kelas ?? '-',
                        'semester' => $jadwal->semester,
                        'tahun_ajaran' => $jadwal->tahunAjaran->tahun_ajaran ?? '-',
                        'guru' => $jadwal->guru->nama_guru ?? '-',
                    ],
                    'bobot' => [
                        'id' => $bobot->id,
                        'bobot_sumatif' => $bobot->bobot_sumatif,
                        'bobot_sas' => $bobot->bobot_sas,
                        'status' => $bobot->status ?? 'draft'
                    ],
                    'rencana' => $rencanaPenilaian->map(function ($r) {
                        return [
                            'id' => $r->id,
                            'bobot_penilaian_id' => $r->bobot_penilaian_id,
                            'nama_penilaian' => $r->nama_penilaian,
                            'kode_penilaian' => $r->kode_penilaian,
                            'kategori_penilaian' => $r->kategori_penilaian,
                            'keterangan' => $r->keterangan,
                            'tanggal_penilaian' => $r->tanggal_penilaian,
                        ];
                    }),
                    'students' => $studentsData
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function storeBobot(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required|exists:bobot_penilaian,id',
            'bobot_sumatif' => 'required|numeric|min:0|max:100',
            'bobot_sas' => 'required|numeric|min:0|max:100',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'errors' => $validator->errors()], 422);
        }

        if (($request->bobot_sumatif + $request->bobot_sas) != 100) {
            return response()->json(['success' => false, 'message' => 'Total bobot harus 100%'], 400);
        }

        $bobot = BobotPenilaian::findOrFail($request->id);
        if ($bobot->status === 'terkirim') {
            return response()->json(['success' => false, 'message' => 'Nilai sudah dikirim dan dikunci.'], 400);
        }

        $bobot->update([
            'bobot_sumatif' => $request->bobot_sumatif,
            'bobot_sas' => $request->bobot_sas,
        ]);

        return response()->json(['success' => true, 'message' => 'Bobot penilaian berhasil diperbarui.']);
    }

    public function storeRencana(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'bobot_penilaian_id' => 'required|exists:bobot_penilaian,id',
            'nama_penilaian'     => 'required|string|max:100',
            'kode_penilaian'     => 'required|string|max:10',
            'kategori_penilaian' => 'required|in:SUMATIF,SAS',
            'tanggal_penilaian'  => 'nullable|date',
            'keterangan'         => 'nullable|string'
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'errors' => $validator->errors()], 422);
        }

        $bobot = BobotPenilaian::findOrFail($request->bobot_penilaian_id);
        if ($bobot->status === 'terkirim') {
            return response()->json(['success' => false, 'message' => 'Nilai sudah dikirim dan dikunci.'], 400);
        }

        $rencana = RencanaPenilaian::create([
            'bobot_penilaian_id' => $request->bobot_penilaian_id,
            'nama_penilaian' => $request->nama_penilaian,
            'kode_penilaian' => $request->kode_penilaian,
            'kategori_penilaian' => $request->kategori_penilaian,
            'keterangan' => $request->keterangan,
            'tanggal_penilaian' => $request->tanggal_penilaian ?? now(),
        ]);

        return response()->json(['success' => true, 'message' => 'Rencana penilaian berhasil ditambahkan.', 'data' => $rencana]);
    }

    public function destroyRencana($id)
    {
        $rencana = RencanaPenilaian::with('bobotPenilaian')->findOrFail($id);
        if ($rencana->bobotPenilaian && $rencana->bobotPenilaian->status === 'terkirim') {
            return response()->json(['success' => false, 'message' => 'Nilai sudah dikirim dan dikunci.'], 400);
        }

        $rencana->delete();
        return response()->json(['success' => true, 'message' => 'Rencana penilaian berhasil dihapus.']);
    }

    public function getManageNilai($bobot_id, $kategori)
    {
        try {
            $bobot = BobotPenilaian::with(['kelas', 'mapel', 'guru'])->findOrFail($bobot_id);

            if (!in_array($kategori, ['SUMATIF', 'SAS'])) {
                return response()->json(['success' => false, 'message' => 'Kategori penilaian tidak valid.'], 400);
            }

            $rencanaPenilaian = RencanaPenilaian::where('bobot_penilaian_id', $bobot_id)
                ->where('kategori_penilaian', $kategori)
                ->orderBy('id')
                ->get();

            $students = Kelassiswa::where('kode_kelas', $bobot->kode_kelas)
                ->join('siswa', 'kelas_siswa.id_siswa', '=', 'siswa.id_siswa')
                ->leftJoin('pendaftaran', 'siswa.id_siswa', '=', 'pendaftaran.id_siswa')
                ->orderBy('siswa.nama_lengkap')
                ->select('siswa.id_siswa', 'pendaftaran.nis', 'siswa.nama_lengkap', 'siswa.jenis_kelamin', 'pendaftaran.foto')
                ->get();

            $grades = NilaiSiswa::whereIn('rencana_penilaian_id', $rencanaPenilaian->pluck('id'))
                ->get()
                ->groupBy('id_siswa');

            $mappedGrades = [];
            foreach ($students as $s) {
                $studentId = $s->id_siswa;
                $mappedGrades[$studentId] = [];
                foreach ($rencanaPenilaian as $r) {
                    $mappedGrades[$studentId][$r->id] = '';
                }
            }

            foreach ($grades as $studentId => $studentGrades) {
                foreach ($studentGrades as $grade) {
                    $mappedGrades[$studentId][$grade->rencana_penilaian_id] = $grade->nilai;
                }
            }

            return response()->json([
                'success' => true,
                'data' => [
                    'bobot' => [
                        'id' => $bobot->id,
                        'kode_kelas' => $bobot->kode_kelas,
                        'nama_kelas' => $bobot->kelas->nama_kelas ?? '-',
                        'nama_mapel' => $bobot->mapel->nama_matpel ?? '-',
                        'status' => $bobot->status ?? 'draft'
                    ],
                    'rencana' => $rencanaPenilaian->map(function ($r) {
                        return [
                            'id' => $r->id,
                            'nama_penilaian' => $r->nama_penilaian,
                            'kode_penilaian' => $r->kode_penilaian,
                        ];
                    }),
                    'students' => $students->map(function ($s) {
                        return [
                            'id_siswa' => $s->id_siswa,
                            'nis' => $s->nis ?? '-',
                            'nama_lengkap' => $s->nama_lengkap,
                            'foto' => $s->foto
                        ];
                    }),
                    'grades' => $mappedGrades
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function storeMultiNilai(Request $request)
    {
        $data = $request->input('nilai'); // format: [student_id => [rencana_id => score]]

        if (!$data || !is_array($data)) {
            return response()->json(['success' => false, 'message' => 'Tidak ada data nilai yang dikirim.'], 400);
        }

        // Check lock status
        $firstStudent = reset($data);
        if ($firstStudent && is_array($firstStudent)) {
            $firstRencanaId = key($firstStudent);
            $rencana = RencanaPenilaian::with('bobotPenilaian')->find($firstRencanaId);
            if ($rencana && $rencana->bobotPenilaian && $rencana->bobotPenilaian->status === 'terkirim') {
                return response()->json(['success' => false, 'message' => 'Nilai sudah dikirim dan dikunci.'], 400);
            }
        }

        DB::beginTransaction();
        try {
            foreach ($data as $studentId => $rencanaScores) {
                foreach ($rencanaScores as $rencanaId => $score) {
                    if ($score !== null && $score !== '') {
                        NilaiSiswa::updateOrCreate(
                            [
                                'rencana_penilaian_id' => $rencanaId,
                                'id_siswa' => $studentId
                            ],
                            [
                                'nilai' => $score
                            ]
                        );
                    } else {
                        NilaiSiswa::where('rencana_penilaian_id', $rencanaId)
                            ->where('id_siswa', $studentId)
                            ->delete();
                    }
                }
            }
            DB::commit();
            return response()->json(['success' => true, 'message' => 'Nilai berhasil disimpan.']);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => 'Terjadi kesalahan: ' . $e->getMessage()], 500);
        }
    }

    public function kirimNilai(Request $request)
    {
        $request->validate([
            'bobot_id' => 'required|exists:bobot_penilaian,id',
        ]);

        $bobot = BobotPenilaian::findOrFail($request->bobot_id);

        if ($bobot->status === 'terkirim') {
            return response()->json(['success' => false, 'message' => 'Nilai sudah terkirim.'], 400);
        }

        $bobot->update([
            'status' => 'terkirim'
        ]);

        return response()->json(['success' => true, 'message' => 'Nilai berhasil dikirim dan dikunci.']);
    }

    public function batalKirimNilai(Request $request)
    {
        $request->validate([
            'bobot_id' => 'required|exists:bobot_penilaian,id',
        ]);

        $bobot = BobotPenilaian::findOrFail($request->bobot_id);

        if ($bobot->status !== 'terkirim') {
            return response()->json(['success' => false, 'message' => 'Nilai belum terkirim.'], 400);
        }

        $bobot->update([
            'status' => 'draft'
        ]);

        return response()->json(['success' => true, 'message' => 'Pengiriman nilai berhasil dibatalkan.']);
    }
}
