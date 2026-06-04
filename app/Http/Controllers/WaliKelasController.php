<?php

namespace App\Http\Controllers;

use App\Models\Guru;
use App\Models\Kelas;
use App\Models\Tahunajaran;
use App\Models\Semester;
use App\Models\JadwalPelajaran;
use App\Models\BobotPenilaian;
use App\Models\RencanaPenilaian;
use App\Models\NilaiSiswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WaliKelasController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        if (!$user->hasRole('guru')) {
            abort(403, 'Akses ditolak. Halaman ini hanya untuk Wali Kelas.');
        }

        $guruModel = Guru::where('npp', $user->npp)->first();
        if (!$guruModel) {
            abort(404, 'Data guru tidak ditemukan.');
        }

        $activeTa = Tahunajaran::where('status', '1')->first();
        if (!$activeTa) {
            return redirect()->back()->with('error', 'Tahun ajaran aktif tidak ditemukan.');
        }

        // Fetch classes where this teacher is Wali Kelas
        $kelasBinaan = Kelas::with(['unit'])
            ->withCount(['siswa'])
            ->where('guru_id', $guruModel->id)
            ->where('kode_ta', $activeTa->kode_ta)
            ->get();

        if ($kelasBinaan->isEmpty()) {
            abort(403, 'Anda tidak ditugaskan sebagai Wali Kelas pada tahun ajaran aktif.');
        }

        $selected_kelas = $request->kode_kelas;
        if (!$selected_kelas) {
            $selected_kelas = $kelasBinaan->first()->kode_kelas;
        }

        $currentKelas = $kelasBinaan->where('kode_kelas', $selected_kelas)->first();
        if (!$currentKelas) {
            abort(404, 'Kelas binaan tidak ditemukan.');
        }

        // Get students in this selected class
        $students = \App\Models\Kelassiswa::where('kode_kelas', $selected_kelas)
            ->join('siswa', 'kelas_siswa.id_siswa', '=', 'siswa.id_siswa')
            ->leftJoin('pendaftaran', 'siswa.id_siswa', '=', 'pendaftaran.id_siswa')
            ->orderBy('siswa.nama_lengkap')
            ->select('siswa.id_siswa', 'pendaftaran.nis', 'siswa.nama_lengkap', 'siswa.jenis_kelamin', 'siswa.tempat_lahir', 'siswa.tanggal_lahir', 'pendaftaran.foto')
            ->get();

        // Get active semester
        $activeSemester = Semester::where('status', '1')->first();
        $selectedSemester = $activeSemester ? $activeSemester->semester : '1';

        // Fetch unique schedules / subjects taught in this class for active TA and active semester
        $schedules = JadwalPelajaran::with(['mapel', 'guru'])
            ->where('kode_kelas', $selected_kelas)
            ->where('kode_ta', $activeTa->kode_ta)
            ->where('semester', $selectedSemester)
            ->select('mata_pelajaran_id', 'guru_id', 'kode_kelas', 'kode_ta', 'semester', \Illuminate\Support\Facades\DB::raw('MIN(id) as id'))
            ->groupBy('mata_pelajaran_id', 'guru_id', 'kode_kelas', 'kode_ta', 'semester')
            ->get();

        $totalStudents = $students->count();

        $monitoringData = $schedules->map(function ($schedule) use ($totalStudents, $selected_kelas, $activeTa, $selectedSemester) {
            // Find BobotPenilaian
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

                // If grades are already submitted/sent, consider it 100% complete
                if ($bobot->status === 'terkirim') {
                    $completionRate = 100;
                    $status = 'Lengkap';
                }
            }

            return (object) [
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

        $agent = new \Jenssegers\Agent\Agent();
        if ($agent->isMobile()) {
            return view('akademik.wali_kelas.index_mobile', compact('guruModel', 'activeTa', 'activeSemester', 'kelasBinaan', 'currentKelas', 'students', 'monitoringData', 'presenceSchedules'));
        }

        return view('akademik.wali_kelas.index', compact('guruModel', 'activeTa', 'activeSemester', 'kelasBinaan', 'currentKelas', 'students', 'monitoringData', 'presenceSchedules'));
    }

    public function detailPenilaian($jadwal_id)
    {
        $user = Auth::user();
        if (!$user->hasRole('guru')) {
            abort(403, 'Akses ditolak. Halaman ini hanya untuk Wali Kelas.');
        }

        $guruModel = Guru::where('npp', $user->npp)->first();
        if (!$guruModel) {
            abort(404, 'Data guru tidak ditemukan.');
        }

        $jadwal = JadwalPelajaran::with(['kelas', 'mapel', 'guru', 'tahunAjaran'])->findOrFail($jadwal_id);

        $isWaliKelas = Kelas::where('kode_kelas', $jadwal->kode_kelas)
            ->where('guru_id', $guruModel->id)
            ->exists();

        if (!$isWaliKelas) {
            abort(403, 'Akses ditolak. Anda bukan Wali Kelas untuk kelas ini.');
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
            ->withCount('nilaiSiswa')
            ->orderBy('created_at')
            ->get();

        $students = \App\Models\Kelassiswa::where('kode_kelas', $bobot->kode_kelas)
            ->join('siswa', 'kelas_siswa.id_siswa', '=', 'siswa.id_siswa')
            ->leftJoin('pendaftaran', 'siswa.id_siswa', '=', 'pendaftaran.id_siswa')
            ->orderBy('siswa.nama_lengkap')
            ->select('siswa.id_siswa', 'pendaftaran.nis', 'siswa.nama_lengkap')
            ->get();

        $grades = NilaiSiswa::whereIn('rencana_penilaian_id', $rencanaPenilaian->pluck('id'))
            ->get()
            ->groupBy('id_siswa');

        $mappedGrades = [];
        foreach ($grades as $studentId => $studentGrades) {
            foreach ($studentGrades as $grade) {
                $mappedGrades[$studentId][$grade->rencana_penilaian_id] = $grade->nilai;
            }
        }

        $students->map(function ($student) use ($grades, $rencanaPenilaian, $bobot) {
            $student_grades = $grades->get($student->id_siswa, collect());
            
            $sumatif_ids = $rencanaPenilaian->where('kategori_penilaian', 'SUMATIF')->pluck('id');
            $sumatif_scores = $student_grades->whereIn('rencana_penilaian_id', $sumatif_ids)->pluck('nilai');
            $avg_sumatif = $sumatif_scores->count() > 0 ? $sumatif_scores->avg() : 0;
            
            $sas_ids = $rencanaPenilaian->where('kategori_penilaian', 'SAS')->pluck('id');
            $sas_scores = $student_grades->whereIn('rencana_penilaian_id', $sas_ids)->pluck('nilai');
            $nilai_sas = $sas_scores->count() > 0 ? $sas_scores->avg() : 0;
            
            $nilai_rapor = ($avg_sumatif * ($bobot->bobot_sumatif / 100)) + ($nilai_sas * ($bobot->bobot_sas / 100));

            $student->rata_sumatif = number_format($avg_sumatif, 0);
            $student->nilai_sas = number_format($nilai_sas, 0);
            $student->nilai_rapor = number_format($nilai_rapor, 0);
            
            $student->capaian_kompetensi = $nilai_rapor >= 75 
                ? "Menunjukkan penguasaan yang baik." 
                : "Perlu bimbingan lebih lanjut.";
                
            return $student;
        });

        $agent = new \Jenssegers\Agent\Agent();
        if ($agent->isMobile()) {
            return view('akademik.wali_kelas.detail_penilaian_mobile', compact('jadwal', 'bobot', 'rencanaPenilaian', 'students', 'mappedGrades'));
        }

        return view('akademik.wali_kelas.detail_penilaian', compact('jadwal', 'bobot', 'rencanaPenilaian', 'students', 'mappedGrades'));
    }
}
