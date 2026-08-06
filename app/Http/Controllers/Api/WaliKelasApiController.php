<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Guru;
use App\Models\Kelas;
use App\Models\Tahunajaran;
use App\Models\Semester;
use App\Models\JadwalPelajaran;
use App\Models\BobotPenilaian;
use App\Models\RencanaPenilaian;
use App\Models\NilaiSiswa;
use App\Models\Kelassiswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class WaliKelasApiController extends Controller
{
    public function index(Request $request)
    {
        try {
            $user = auth()->user();
            if (!$user->hasRole('guru')) {
                return response()->json(['success' => false, 'message' => 'Akses ditolak. Fitur ini hanya untuk Wali Kelas.'], 403);
            }

            $guruModel = Guru::where('npp', $user->npp)->first();
            if (!$guruModel) {
                return response()->json(['success' => false, 'message' => 'Data guru tidak ditemukan.'], 404);
            }

            $activeTa = Tahunajaran::where('status', '1')->first();
            if (!$activeTa) {
                return response()->json(['success' => false, 'message' => 'Tahun ajaran aktif tidak ditemukan.'], 404);
            }

            // Fetch classes where this teacher is Wali Kelas
            $kelasBinaan = Kelas::with(['unit'])
                ->withCount(['siswa'])
                ->where('guru_id', $guruModel->id)
                ->where('kode_ta', $activeTa->kode_ta)
                ->get();

            if ($kelasBinaan->isEmpty()) {
                return response()->json(['success' => false, 'message' => 'Anda tidak ditugaskan sebagai Wali Kelas pada tahun ajaran aktif.'], 403);
            }

            $selected_kelas = $request->kode_kelas;
            if (!$selected_kelas) {
                $selected_kelas = $kelasBinaan->first()->kode_kelas;
            }

            $currentKelas = $kelasBinaan->where('kode_kelas', $selected_kelas)->first();
            if (!$currentKelas) {
                return response()->json(['success' => false, 'message' => 'Kelas binaan tidak ditemukan.'], 404);
            }

            // Get students in this selected class
            $students = Kelassiswa::where('kode_kelas', $selected_kelas)
                ->join('siswa', 'kelas_siswa.id_siswa', '=', 'siswa.id_siswa')
                ->leftJoin('pendaftaran', 'siswa.id_siswa', '=', 'pendaftaran.id_siswa')
                ->orderBy('siswa.nama_lengkap')
                ->select(
                    'siswa.id_siswa', 
                    'pendaftaran.nis', 
                    'siswa.nama_lengkap', 
                    'siswa.jenis_kelamin', 
                    'pendaftaran.foto',
                    'siswa.nisn',
                    'siswa.tempat_lahir',
                    'siswa.tanggal_lahir',
                    'siswa.alamat',
                    'siswa.kode_pos',
                    'siswa.no_kk',
                    'siswa.anak_ke',
                    'siswa.jumlah_saudara',
                    'siswa.nik_ayah',
                    'siswa.nama_ayah',
                    'siswa.pendidikan_ayah',
                    'siswa.pekerjaan_ayah',
                    'siswa.nik_ibu',
                    'siswa.nama_ibu',
                    'siswa.pendidikan_ibu',
                    'siswa.pekerjaan_ibu',
                    'siswa.no_hp_orang_tua'
                )
                ->get();

            // Get active semester
            $activeSemester = Semester::where('status', '1')->first();
            $selectedSemester = $activeSemester ? $activeSemester->semester : '1';

            // Fetch unique schedules / subjects taught in this class for active TA and active semester
            $schedules = JadwalPelajaran::with(['mapel', 'guru'])
                ->where('kode_kelas', $selected_kelas)
                ->where('kode_ta', $activeTa->kode_ta)
                ->where('semester', $selectedSemester)
                ->select('mata_pelajaran_id', 'guru_id', 'kode_kelas', 'kode_ta', 'semester', DB::raw('MIN(id) as id'))
                ->groupBy('mata_pelajaran_id', 'guru_id', 'kode_kelas', 'kode_ta', 'semester')
                ->get();

            $totalStudents = $students->count();

            $monitoringData = $schedules->map(function ($schedule) use ($totalStudents, $selected_kelas, $activeTa, $selectedSemester) {
                $bobot = BobotPenilaian::where('kode_kelas', $selected_kelas)
                    ->where('mata_pelajaran_id', $schedule->mata_pelajaran_id)
                    ->where('kode_ta', $activeTa->kode_ta)
                    ->where('semester', $selectedSemester)
                    ->first();

                $rencanaCount = 0;
                $rencanaSumatif = 0;
                $rencanaSas = 0;
                $nilaiCount = 0;
                $expectedCount = 0;
                $completionRate = 0;
                $status = 'Belum Ada Rencana';

                if ($bobot) {
                    $rencanaList = RencanaPenilaian::where('bobot_penilaian_id', $bobot->id)->get();
                    $rencanaCount = $rencanaList->count();
                    $rencanaSumatif = $rencanaList->where('kategori_penilaian', 'SUMATIF')->count();
                    $rencanaSas = $rencanaList->where('kategori_penilaian', 'SAS')->count();

                    if ($rencanaCount > 0) {
                        $rencanaIds = $rencanaList->pluck('id');
                        $nilaiCount = NilaiSiswa::whereIn('rencana_penilaian_id', $rencanaIds)->count();
                        $expectedCount = $totalStudents * $rencanaCount;

                        if ($expectedCount > 0) {
                            $completionRate = round(($nilaiCount / $expectedCount) * 100);
                        }

                        if ($nilaiCount === 0) {
                            $status = 'Belum Diisi';
                        } elseif ($nilaiCount < $expectedCount) {
                            $status = 'Belum Lengkap';
                        } else {
                            $status = 'Lengkap';
                        }
                    }

                    if ($bobot->status === 'terkirim') {
                        $completionRate = 100;
                        $status = 'Lengkap';
                    }
                }

                return [
                    'jadwal_id' => $schedule->id,
                    'mapel_nama' => $schedule->mapel ? $schedule->mapel->nama_matpel : 'Mapel Tidak Diketahui',
                    'guru_nama' => $schedule->guru ? $schedule->guru->nama_guru : 'Guru Tidak Diketahui',
                    'rencana_sumatif' => $rencanaSumatif,
                    'rencana_sas' => $rencanaSas,
                    'nilai_count' => $nilaiCount,
                    'expected_count' => $expectedCount,
                    'completion_rate' => $completionRate,
                    'status' => $status
                ];
            });

            // Fetch all schedules for this class to monitor presence
            $presenceSchedules = JadwalPelajaran::with(['mapel', 'guru'])
                ->withCount('presensi')
                ->where('kode_kelas', $selected_kelas)
                ->where('kode_ta', $activeTa->kode_ta)
                ->where('semester', $selectedSemester)
                ->orderByRaw("FIELD(hari, 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Ahad')")
                ->orderBy('jam_ke')
                ->get();

            return response()->json([
                'success' => true,
                'data' => [
                    'active_ta' => $activeTa->tahun_ajaran,
                    'active_semester' => $selectedSemester,
                    'kelas_binaan' => $kelasBinaan->map(function ($k) {
                        return [
                            'kode_kelas' => $k->kode_kelas,
                            'nama_kelas' => $k->nama_kelas,
                            'nama_unit' => $k->unit->nama_unit ?? '-',
                            'total_siswa' => $k->siswa_count
                        ];
                    }),
                    'current_kelas' => [
                        'kode_kelas' => $currentKelas->kode_kelas,
                        'nama_kelas' => $currentKelas->nama_kelas,
                        'nama_unit' => $currentKelas->unit->nama_unit ?? '-',
                        'total_siswa' => $totalStudents
                    ],
                    'students' => $students->map(function ($s) {
                        return [
                            'id_siswa' => $s->id_siswa,
                            'nis' => $s->nis ?? '-',
                            'nama_lengkap' => $s->nama_lengkap,
                            'jenis_kelamin' => $s->jenis_kelamin,
                            'foto' => $s->foto,
                            'nisn' => $s->nisn ?? '-',
                            'tempat_lahir' => $s->tempat_lahir ?? '-',
                            'tanggal_lahir' => $s->tanggal_lahir ? (\Illuminate\Support\Carbon::parse($s->tanggal_lahir)->format('Y-m-d')) : '-',
                            'alamat' => $s->alamat ?? '-',
                            'kode_pos' => $s->kode_pos ?? '-',
                            'no_kk' => $s->no_kk ?? '-',
                            'anak_ke' => $s->anak_ke ?? '-',
                            'jumlah_saudara' => $s->jumlah_saudara ?? '-',
                            'nik_ayah' => $s->nik_ayah ?? '-',
                            'nama_ayah' => $s->nama_ayah ?? '-',
                            'pendidikan_ayah' => $s->pendidikan_ayah ?? '-',
                            'pekerjaan_ayah' => $s->pekerjaan_ayah ?? '-',
                            'nik_ibu' => $s->nik_ibu ?? '-',
                            'nama_ibu' => $s->nama_ibu ?? '-',
                            'pendidikan_ibu' => $s->pendidikan_ibu ?? '-',
                            'pekerjaan_ibu' => $s->pekerjaan_ibu ?? '-',
                            'no_hp_orang_tua' => $s->no_hp_orang_tua ?? '-'
                        ];
                    }),
                    'monitoring' => $monitoringData,
                    'presence_schedules' => $presenceSchedules->map(function ($ps) {
                        return [
                            'id' => $ps->id,
                            'hari' => $ps->hari,
                            'jam_ke' => $ps->jam_ke,
                            'jam_mulai' => $ps->jam_mulai,
                            'jam_selesai' => $ps->jam_selesai,
                            'mapel_nama' => $ps->mapel->nama_matpel ?? '-',
                            'guru_nama' => $ps->guru->nama_guru ?? '-',
                            'total_presensi' => $ps->presensi_count
                        ];
                    })
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function detailPenilaian($jadwal_id)
    {
        try {
            $user = auth()->user();
            if (!$user->hasRole('guru')) {
                return response()->json(['success' => false, 'message' => 'Akses ditolak.'], 403);
            }

            $guruModel = Guru::where('npp', $user->npp)->first();
            if (!$guruModel) {
                return response()->json(['success' => false, 'message' => 'Data guru tidak ditemukan.'], 404);
            }

            $jadwal = JadwalPelajaran::with(['kelas', 'mapel', 'guru', 'tahunAjaran'])->findOrFail($jadwal_id);

            $isWaliKelas = Kelas::where('kode_kelas', $jadwal->kode_kelas)
                ->where('guru_id', $guruModel->id)
                ->exists();

            if (!$isWaliKelas) {
                return response()->json(['success' => false, 'message' => 'Akses ditolak. Anda bukan Wali Kelas untuk kelas ini.'], 403);
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
                ]
            );

            $rencanaPenilaian = RencanaPenilaian::where('bobot_penilaian_id', $bobot->id)
                ->orderBy('created_at')
                ->get();

            $students = Kelassiswa::where('kode_kelas', $bobot->kode_kelas)
                ->join('siswa', 'kelas_siswa.id_siswa', '=', 'siswa.id_siswa')
                ->leftJoin('pendaftaran', 'siswa.id_siswa', '=', 'pendaftaran.id_siswa')
                ->orderBy('siswa.nama_lengkap')
                ->select('siswa.id_siswa', 'pendaftaran.nis', 'siswa.nama_lengkap', 'pendaftaran.foto')
                ->get();

            $grades = NilaiSiswa::whereIn('rencana_penilaian_id', $rencanaPenilaian->pluck('id'))
                ->get()
                ->groupBy('id_siswa');

            $studentsData = $students->map(function ($student) use ($grades, $rencanaPenilaian, $bobot) {
                $student_grades = $grades->get($student->id_siswa, collect());

                $sumatif_ids = $rencanaPenilaian->where('kategori_penilaian', 'SUMATIF')->pluck('id');
                $sumatif_scores = $student_grades->whereIn('rencana_penilaian_id', $sumatif_ids)->pluck('nilai');
                $avg_sumatif = $sumatif_scores->count() > 0 ? $sumatif_scores->avg() : 0;

                $sas_ids = $rencanaPenilaian->where('kategori_penilaian', 'SAS')->pluck('id');
                $sas_scores = $student_grades->whereIn('rencana_penilaian_id', $sas_ids)->pluck('nilai');
                $nilai_sas = $sas_scores->count() > 0 ? $sas_scores->avg() : 0;

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
                    'bobot' => [
                        'id' => $bobot->id,
                        'bobot_sumatif' => $bobot->bobot_sumatif,
                        'bobot_sas' => $bobot->bobot_sas,
                        'status' => $bobot->status ?? 'draft'
                    ],
                    'jadwal' => [
                        'id' => $jadwal->id,
                        'nama_mapel' => $jadwal->mapel->nama_matpel ?? '-',
                        'nama_kelas' => $jadwal->kelas->nama_kelas ?? '-',
                        'guru' => $jadwal->guru->nama_guru ?? '-',
                    ],
                    'rencana' => $rencanaPenilaian->map(function ($r) {
                        return [
                            'id' => $r->id,
                            'nama_penilaian' => $r->nama_penilaian,
                            'kode_penilaian' => $r->kode_penilaian,
                            'kategori_penilaian' => $r->kategori_penilaian,
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
}
