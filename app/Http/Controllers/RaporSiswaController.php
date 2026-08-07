<?php

namespace App\Http\Controllers;

use App\Models\BobotPenilaian;
use App\Models\JadwalPelajaran;
use App\Models\Kelas;
use App\Models\NilaiSiswa;
use App\Models\RencanaPenilaian;
use App\Models\Semester;
use App\Models\Tahunajaran;
use App\Models\MataPelajaran;
use App\Models\Pendaftaran;
use App\Models\PresensiSiswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;

class RaporSiswaController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        
        $isWaliKelas = false;
        $isKoordinator = false;
        $guruModel = null;
        if ($user->hasRole('guru')) {
            $guruModel = \App\Models\Guru::where('npp', $user->npp)->first();
            if ($guruModel) {
                $activeTa = Tahunajaran::where('status', '1')->first();
                if ($activeTa) {
                    $isWaliKelas = Kelas::where('guru_id', $guruModel->id)
                        ->where('kode_ta', $activeTa->kode_ta)
                        ->exists();
                    $isKoordinator = \App\Models\Ekstrakurikuler::where('guru_id', $guruModel->id)
                        ->where('kode_ta', $activeTa->kode_ta)
                        ->exists();
                }
            }
        }

        if (!$user->hasAnyRole(['super admin', 'admin']) && !$user->can('jadwalpelajaran.index') && !$isKoordinator && !$isWaliKelas) {
            abort(403, 'Akses ditolak.');
        }

        $activeTa = Tahunajaran::where('status', '1')->first();
        $semuaTa = Tahunajaran::orderBy('tahun_ajaran', 'desc')->get();
        
        $selectedKodeTa = $request->kode_ta;
        if(!$selectedKodeTa && $activeTa) {
            $selectedKodeTa = $activeTa->kode_ta;
        }

        $activeSemester = Semester::where('status', '1')->first();
        $selectedSemester = $request->semester;
        if(!$selectedSemester) {
            $selectedSemester = $activeSemester ? $activeSemester->semester : '1';
        }

        if ($user->kode_unit != 'U06') {
            $units = \App\Models\Unit::where('kode_unit', $user->kode_unit)->get();
        } else {
            $units = \App\Models\Unit::all();
        }

        // Get unique tingkat values
        $tingkatsQuery = Kelas::query();
        if ($user->kode_unit != 'U06') {
            $tingkatsQuery->where('kode_unit', $user->kode_unit);
        } else {
            if ($request->has('kode_unit') && $request->kode_unit != '') {
                $tingkatsQuery->where('kode_unit', $request->kode_unit);
            }
        }
        $tingkats = $tingkatsQuery->whereNotNull('tingkat')->distinct()->orderBy('tingkat')->pluck('tingkat');

        $selectedTingkat = $request->tingkat;
        $selectedKodeKelas = $request->kode_kelas;

        // Fetch all classes filtered by unit and ta
        $query = Kelas::with(['unit', 'waliKelas'])
            ->withCount('siswa');

        if ($selectedKodeTa) {
            $query->where('kode_ta', $selectedKodeTa);
        }

        if ($user->kode_unit != 'U06') {
            $query->where('kode_unit', $user->kode_unit);
        } else {
            if ($request->has('kode_unit') && $request->kode_unit != '') {
                $query->where('kode_unit', $request->kode_unit);
            }
        }

        if ($selectedTingkat) {
            $query->where('tingkat', $selectedTingkat);
        }

        if ($selectedKodeKelas) {
            $query->where('kode_kelas', $selectedKodeKelas);
        }

        if (!$user->hasAnyRole(['super admin', 'admin', 'admin unit', 'admin tu']) && $user->hasRole('guru')) {
            if ($guruModel) {
                $query->where('guru_id', $guruModel->id);
            }
        }

        // Get class options for dropdown
        $kelasDropdownQuery = Kelas::query();
        if ($selectedKodeTa) {
            $kelasDropdownQuery->where('kode_ta', $selectedKodeTa);
        }
        if ($user->kode_unit != 'U06') {
            $kelasDropdownQuery->where('kode_unit', $user->kode_unit);
        } else {
            if ($request->has('kode_unit') && $request->kode_unit != '') {
                $kelasDropdownQuery->where('kode_unit', $request->kode_unit);
            }
        }
        if ($selectedTingkat) {
            $kelasDropdownQuery->where('tingkat', $selectedTingkat);
        }
        $kelasDropdown = $kelasDropdownQuery->orderBy('nama_kelas')->get();

        $classes = $query->get();

        // For each class, calculate progress
        foreach ($classes as $class) {
            $schedules = JadwalPelajaran::where('kode_kelas', $class->kode_kelas)
                ->where('kode_ta', $selectedKodeTa)
                ->where('semester', $selectedSemester)
                ->select('mata_pelajaran_id', 'guru_id', 'kode_kelas', 'kode_ta', 'semester')
                ->groupBy('mata_pelajaran_id', 'guru_id', 'kode_kelas', 'kode_ta', 'semester')
                ->get();

            $totalStudents = $class->siswa_count;
            $totalSubjects = $schedules->count();
            $completedSubjects = 0;
            $totalCompletionRate = 0;

            if ($totalSubjects > 0) {
                foreach ($schedules as $schedule) {
                    $bobot = BobotPenilaian::where('kode_kelas', $class->kode_kelas)
                        ->where('mata_pelajaran_id', $schedule->mata_pelajaran_id)
                        ->where('kode_ta', $selectedKodeTa)
                        ->where('semester', $selectedSemester)
                        ->first();

                    $rate = 0;
                    if ($bobot) {
                        if ($bobot->status === 'terkirim') {
                            $rate = 100;
                        } else {
                            $rencanaList = RencanaPenilaian::where('bobot_penilaian_id', $bobot->id)->get();
                            $rencanaCount = $rencanaList->count();
                            if ($rencanaCount > 0) {
                                $nilaiCount = NilaiSiswa::whereIn('rencana_penilaian_id', $rencanaList->pluck('id'))->count();
                                $expectedCount = $totalStudents * $rencanaCount;
                                if ($expectedCount > 0) {
                                    $rate = round(($nilaiCount / $expectedCount) * 100);
                                }
                            }
                        }
                    }
                    $totalCompletionRate += $rate;
                    if ($rate === 100) {
                        $completedSubjects++;
                    }
                }
                $class->progress = round($totalCompletionRate / $totalSubjects);
                $class->completed_subjects = $completedSubjects;
                $class->total_subjects = $totalSubjects;
            } else {
                $class->progress = 0;
                $class->completed_subjects = 0;
                $class->total_subjects = 0;
            }
        }

        // Fetch extracurriculars for the selected ta and optionally filtered by unit
        $ekstrakurikulerQuery = \App\Models\Ekstrakurikuler::with(['guru.karyawan', 'unit', 'tahunAjaran'])
            ->where('kode_ta', $selectedKodeTa);

        if (!$user->hasAnyRole(['super admin', 'admin']) && $user->hasRole('guru')) {
            if ($guruModel) {
                $ekstrakurikulerQuery->where('guru_id', $guruModel->id);
            }
        }

        if ($request->has('kode_unit') && $request->kode_unit != '') {
            $ekstrakurikulerQuery->where('kode_unit', $request->kode_unit);
        }

        $ekstrakurikuler = $ekstrakurikulerQuery->get();

        // Fetch teachers list for coordinator
        $gurus = \App\Models\Guru::with('karyawan')
            ->where('status_aktif_ajar', 1)
            ->get()
            ->sortBy(function($g) {
                return $g->nama_guru;
            });

        $agent = new \Jenssegers\Agent\Agent();
        if ($agent->isMobile()) {
            return view('akademik.rapor_siswa.index_mobile', compact('classes', 'activeTa', 'semuaTa', 'selectedKodeTa', 'activeSemester', 'selectedSemester', 'units', 'ekstrakurikuler', 'gurus', 'isWaliKelas', 'isKoordinator', 'tingkats', 'kelasDropdown', 'selectedTingkat', 'selectedKodeKelas'));
        }

        return view('akademik.rapor_siswa.index', compact('classes', 'activeTa', 'semuaTa', 'selectedKodeTa', 'activeSemester', 'selectedSemester', 'units', 'ekstrakurikuler', 'gurus', 'isWaliKelas', 'isKoordinator', 'tingkats', 'kelasDropdown', 'selectedTingkat', 'selectedKodeKelas'));
    }

    public function show($kode_kelas)
    {
        $user = Auth::user();
        if (!$user->hasAnyRole(['super admin', 'admin']) && !$user->can('jadwalpelajaran.index')) {
            abort(403, 'Akses ditolak.');
        }

        $activeTa = Tahunajaran::where('status', '1')->first();
        $activeSemester = Semester::where('status', '1')->first();
        $selectedSemester = $activeSemester ? $activeSemester->semester : '1';

        $class = Kelas::with(['unit', 'waliKelas'])->findOrFail($kode_kelas);
        $totalStudents = $class->siswa()->count();

        $schedules = JadwalPelajaran::with(['mapel', 'guru'])
            ->where('kode_kelas', $kode_kelas)
            ->where('kode_ta', $activeTa->kode_ta)
            ->where('semester', $selectedSemester)
            ->select('mata_pelajaran_id', 'guru_id', 'kode_kelas', 'kode_ta', 'semester', \Illuminate\Support\Facades\DB::raw('MIN(id) as id'))
            ->groupBy('mata_pelajaran_id', 'guru_id', 'kode_kelas', 'kode_ta', 'semester')
            ->get();

        $monitoringData = $schedules->map(function ($schedule) use ($totalStudents, $kode_kelas, $activeTa, $selectedSemester) {
            $bobot = BobotPenilaian::where('kode_kelas', $kode_kelas)
                ->where('mata_pelajaran_id', $schedule->mata_pelajaran_id)
                ->where('kode_ta', $activeTa->kode_ta)
                ->where('semester', $selectedSemester)
                ->first();

            $rencanaCount = 0;
            $nilaiCount = 0;
            $expectedCount = 0;
            $completionRate = 0;
            $status = 'Belum Ada Rencana';

            if ($bobot) {
                $rencanaList = RencanaPenilaian::where('bobot_penilaian_id', $bobot->id)->get();
                $rencanaCount = $rencanaList->count();

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
                    $status = 'Lengkap (Terkirim)';
                }
            }

            return (object) [
                'jadwal_id' => $schedule->id,
                'mapel_nama' => $schedule->mapel ? $schedule->mapel->nama_matpel : 'Mapel Tidak Diketahui',
                'guru_nama' => $schedule->guru ? $schedule->guru->nama_guru : 'Guru Tidak Diketahui',
                'rencana_count' => $rencanaCount,
                'completion_rate' => $completionRate,
                'status' => $status
            ];
        });

        $students = \App\Models\Kelassiswa::where('kode_kelas', $kode_kelas)
            ->join('siswa', 'kelas_siswa.id_siswa', '=', 'siswa.id_siswa')
            ->leftJoin('pendaftaran', 'siswa.id_siswa', '=', 'pendaftaran.id_siswa')
            ->orderBy('siswa.nama_lengkap')
            ->select('siswa.id_siswa', 'pendaftaran.nis', 'siswa.nama_lengkap', 'siswa.jenis_kelamin', 'pendaftaran.no_pendaftaran')
            ->get();

        return view('akademik.rapor_siswa.show', compact('class', 'activeTa', 'activeSemester', 'monitoringData', 'students'));
    }

    public function detailNilai($jadwal_id)
    {
        $user = Auth::user();
        if (!$user->hasAnyRole(['super admin', 'admin']) && !$user->can('jadwalpelajaran.index')) {
            abort(403, 'Akses ditolak.');
        }

        $jadwal = JadwalPelajaran::with(['kelas', 'mapel', 'guru', 'tahunAjaran'])->findOrFail($jadwal_id);

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

        $activeSemester = Semester::where('status', '1')->first();

        return view('akademik.rapor_siswa.detail_nilai', compact('jadwal', 'bobot', 'rencanaPenilaian', 'students', 'mappedGrades', 'activeSemester'));
    }

    public function previewRapor($no_pendaftaran)
    {
        $user = Auth::user();
        $no_pendaftaran = Crypt::decrypt($no_pendaftaran);
        $pendaftaran = Pendaftaran::with(['siswa'])->where('no_pendaftaran', $no_pendaftaran)->firstOrFail();
        $siswa = $pendaftaran->siswa;

        $isWaliKelas = false;
        $isKoordinator = false;
        if ($user->hasRole('guru')) {
            $guruModel = \App\Models\Guru::where('npp', $user->npp)->first();
            if ($guruModel) {
                $activeTa = Tahunajaran::where('status', '1')->first();
                if ($activeTa) {
                    $isWaliKelas = \App\Models\Kelassiswa::where('id_siswa', $siswa->id_siswa)
                        ->whereHas('kelas', function ($query) use ($activeTa, $guruModel) {
                            $query->where('kode_ta', $activeTa->kode_ta)
                                  ->where('guru_id', $guruModel->id);
                        })
                        ->exists();

                    $isKoordinator = \App\Models\Ekstrakurikuler::where('guru_id', $guruModel->id)
                        ->where('kode_ta', $activeTa->kode_ta)
                        ->exists();
                }
            }
        }

        if (!$user->hasAnyRole(['super admin', 'admin']) && !$user->can('jadwalpelajaran.index') && !$isWaliKelas && !$isKoordinator) {
            abort(403, 'Akses ditolak.');
        }

        $activeTa = Tahunajaran::where('status', '1')->first();
        $activeSemester = Semester::where('status', '1')->first();
        $selectedSemester = $activeSemester ? $activeSemester->semester : '1';

        $kelasSiswa = \App\Models\Kelassiswa::where('id_siswa', $siswa->id_siswa)
            ->whereHas('kelas', function ($query) use ($activeTa) {
                $query->where('kode_ta', $activeTa->kode_ta);
            })
            ->first();
        $kelas = $kelasSiswa ? $kelasSiswa->kelas : null;

        // Fetch root subjects
        $subjects = MataPelajaran::whereNull('parent_id')
            ->with(['children' => function($q) {
                $q->orderBy('urutan');
            }])
            ->orderBy('urutan')
            ->get();

        // Calculate grades for each subject
        foreach ($subjects as $mapel) {
            if ($mapel->children->count() > 0) {
                foreach ($mapel->children as $child) {
                    $child->grade = $this->calculateStudentGrade($siswa->id_siswa, $kelas->kode_kelas ?? '', $child->id, $activeTa->kode_ta, $selectedSemester);
                }
            } else {
                $mapel->grade = $this->calculateStudentGrade($siswa->id_siswa, $kelas->kode_kelas ?? '', $mapel->id, $activeTa->kode_ta, $selectedSemester);
            }
        }

        // Kehadiran
        $kehadiran = (object)[
            'sakit' => PresensiSiswa::where('no_pendaftaran', $no_pendaftaran)->where('status', 's')->count(),
            'izin' => PresensiSiswa::where('no_pendaftaran', $no_pendaftaran)->where('status', 'i')->count(),
            'alpa' => PresensiSiswa::where('no_pendaftaran', $no_pendaftaran)->where('status', 'a')->count(),
        ];

        $pengaturan = \App\Models\PengaturanUmum::first();

        return view('akademik.rapor_siswa.preview_rapor', compact('pendaftaran', 'siswa', 'kelas', 'activeTa', 'activeSemester', 'subjects', 'kehadiran', 'pengaturan'));
    }

    public function cetakRaporPdf(Request $request, $no_pendaftaran)
    {
        $user = Auth::user();
        $no_pendaftaran = Crypt::decrypt($no_pendaftaran);
        $pendaftaran = Pendaftaran::with(['siswa'])->where('no_pendaftaran', $no_pendaftaran)->firstOrFail();
        $siswa = $pendaftaran->siswa;

        $isWaliKelas = false;
        $isKoordinator = false;
        if ($user->hasRole('guru')) {
            $guruModel = \App\Models\Guru::where('npp', $user->npp)->first();
            if ($guruModel) {
                $activeTa = Tahunajaran::where('status', '1')->first();
                if ($activeTa) {
                    $isWaliKelas = \App\Models\Kelassiswa::where('id_siswa', $siswa->id_siswa)
                        ->whereHas('kelas', function ($query) use ($activeTa, $guruModel) {
                            $query->where('kode_ta', $activeTa->kode_ta)
                                  ->where('guru_id', $guruModel->id);
                        })
                        ->exists();

                    $isKoordinator = \App\Models\Ekstrakurikuler::where('guru_id', $guruModel->id)
                        ->where('kode_ta', $activeTa->kode_ta)
                        ->exists();
                }
            }
        }

        if (!$user->hasAnyRole(['super admin', 'admin']) && !$user->can('jadwalpelajaran.index') && !$isWaliKelas && !$isKoordinator) {
            abort(403, 'Akses ditolak.');
        }

        $activeTa = Tahunajaran::where('status', '1')->first();
        $activeSemester = Semester::where('status', '1')->first();
        $selectedSemester = $activeSemester ? $activeSemester->semester : '1';

        $kelasSiswa = \App\Models\Kelassiswa::where('id_siswa', $siswa->id_siswa)
            ->whereHas('kelas', function ($query) use ($activeTa) {
                $query->where('kode_ta', $activeTa->kode_ta);
            })
            ->first();
        $kelas = $kelasSiswa ? $kelasSiswa->kelas : null;

        // Fetch root subjects
        $subjects = MataPelajaran::whereNull('parent_id')
            ->with(['children' => function($q) {
                $q->orderBy('urutan');
            }])
            ->orderBy('urutan')
            ->get();

        // Calculate grades for each subject
        $totalGrade = 0;
        $subjectCount = 0;
        foreach ($subjects as $mapel) {
            if ($mapel->children->count() > 0) {
                foreach ($mapel->children as $child) {
                    $child->grade = $this->calculateStudentGrade($siswa->id_siswa, $kelas->kode_kelas ?? '', $child->id, $activeTa->kode_ta, $selectedSemester);
                    $totalGrade += $child->grade->nilai_rapor;
                    $subjectCount++;
                }
            } else {
                $mapel->grade = $this->calculateStudentGrade($siswa->id_siswa, $kelas->kode_kelas ?? '', $mapel->id, $activeTa->kode_ta, $selectedSemester);
                $totalGrade += $mapel->grade->nilai_rapor;
                $subjectCount++;
            }
        }

        // Kehadiran (override if custom value sent from form)
        $kehadiran = (object)[
            'sakit' => $request->sakit ?? PresensiSiswa::where('no_pendaftaran', $no_pendaftaran)->where('status', 's')->count(),
            'izin' => $request->izin ?? PresensiSiswa::where('no_pendaftaran', $no_pendaftaran)->where('status', 'i')->count(),
            'alpa' => $request->alpa ?? PresensiSiswa::where('no_pendaftaran', $no_pendaftaran)->where('status', 'a')->count(),
        ];

        // Extra details from Form Request
        $kokurikuler = $request->kokurikuler;
        $ekskul = $request->ekskul; // Array of [kegiatan, nilai, keterangan]
        if (empty($ekskul)) {
            $ekskul = \App\Models\NilaiEkstrakurikuler::join('ekstrakurikuler', 'nilai_ekstrakurikuler.ekstrakurikuler_id', '=', 'ekstrakurikuler.id')
                ->where('nilai_ekstrakurikuler.id_siswa', $siswa->id_siswa)
                ->where('ekstrakurikuler.kode_ta', $activeTa->kode_ta)
                ->select('ekstrakurikuler.nama_ekstrakurikuler as kegiatan', 'nilai_ekstrakurikuler.nilai', 'nilai_ekstrakurikuler.keterangan')
                ->get()
                ->toArray();
        }
        $prestasi = $request->prestasi; // Array of [jenis_prestasi, keterangan]
        $catatan_wali = $request->catatan_wali;
        $tanggapan_ortu = $request->tanggapan_ortu;
        $tanggal_cetak = $request->tanggal_cetak ?? now()->translatedFormat('d F Y');

        $pengaturan = \App\Models\PengaturanUmum::first();

        // Get Unit
        $unit = $kelas ? $kelas->unit : null;

        // Generate QR Code for Principal Signature
        $qrCode = null;
        if ($pengaturan && $pengaturan->nama_kepsek) {
            $namaMadrasah = $unit ? $unit->nama_unit : ($pengaturan->nama_madrasah ?? 'MTsS Persis Sindangkasih');
            $qrData = "Rapor Siswa: " . $siswa->nama_lengkap . "\nKelas: " . ($kelas->nama_kelas ?? '-') . "\nMadrasah: " . $namaMadrasah . "\nKepala Madrasah: " . $pengaturan->nama_kepsek;
            $qrCode = 'data:image/png;base64,' . base64_encode(\SimpleSoftwareIO\QrCode\Facades\QrCode::format('png')->size(80)->generate($qrData));
        }

        // Base64 logo conversion for DOMPDF
        $logo_base64 = null;
        if ($pengaturan && $pengaturan->logo && file_exists(public_path('storage/' . $pengaturan->logo))) {
            $logoPath = public_path('storage/' . $pengaturan->logo);
            $logoType = pathinfo($logoPath, PATHINFO_EXTENSION);
            $logoData = file_get_contents($logoPath);
            $logo_base64 = 'data:image/' . $logoType . ';base64,' . base64_encode($logoData);
        }

        // Base64 unit logo conversion for DOMPDF
        $unit_logo_base64 = null;
        if ($unit && $unit->logo && file_exists(public_path('storage/' . $unit->logo))) {
            $logoPath = public_path('storage/' . $unit->logo);
            $logoType = pathinfo($logoPath, PATHINFO_EXTENSION);
            $logoData = file_get_contents($logoPath);
            $unit_logo_base64 = 'data:image/' . $logoType . ';base64,' . base64_encode($logoData);
        }

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('akademik.rapor_siswa.pdf_rapor', compact(
            'pendaftaran', 'siswa', 'kelas', 'activeTa', 'activeSemester', 'subjects', 'kehadiran', 
            'kokurikuler', 'ekskul', 'prestasi', 'catatan_wali', 'tanggapan_ortu', 'tanggal_cetak',
            'pengaturan', 'totalGrade', 'qrCode', 'logo_base64', 'unit', 'unit_logo_base64'
        ))->setPaper('a4', 'portrait');

        return $pdf->stream('rapor_' . str_replace(' ', '_', strtolower($siswa->nama_lengkap)) . '.pdf');
    }

    private function calculateStudentGrade($id_siswa, $kode_kelas, $mata_pelajaran_id, $kode_ta, $semester)
    {
        $bobot = BobotPenilaian::where('kode_kelas', $kode_kelas)
            ->where('mata_pelajaran_id', $mata_pelajaran_id)
            ->where('kode_ta', $kode_ta)
            ->where('semester', $semester)
            ->first();

        if (!$bobot) {
            return (object)['nilai_rapor' => 0, 'capaian_kompetensi' => 'Belum ada penilaian.'];
        }

        $rencanaPenilaian = RencanaPenilaian::where('bobot_penilaian_id', $bobot->id)->get();
        if ($rencanaPenilaian->isEmpty()) {
            return (object)['nilai_rapor' => 0, 'capaian_kompetensi' => 'Belum ada rencana penilaian.'];
        }

        $student_grades = NilaiSiswa::where('id_siswa', $id_siswa)
            ->whereIn('rencana_penilaian_id', $rencanaPenilaian->pluck('id'))
            ->get();

        // Sumatif
        $sumatif_ids = $rencanaPenilaian->where('kategori_penilaian', 'SUMATIF')->pluck('id');
        $sumatif_scores = $student_grades->whereIn('rencana_penilaian_id', $sumatif_ids)->pluck('nilai');
        $avg_sumatif = $sumatif_scores->count() > 0 ? $sumatif_scores->avg() : 0;
        
        // SAS
        $sas_ids = $rencanaPenilaian->where('kategori_penilaian', 'SAS')->pluck('id');
        $sas_scores = $student_grades->whereIn('rencana_penilaian_id', $sas_ids)->pluck('nilai');
        $nilai_sas = $sas_scores->count() > 0 ? $sas_scores->avg() : 0;
        
        $nilai_rapor = ($avg_sumatif * ($bobot->bobot_sumatif / 100)) + ($nilai_sas * ($bobot->bobot_sas / 100));
        $nilai_rapor = round($nilai_rapor);

        $mapel = MataPelajaran::find($mata_pelajaran_id);
        $mapel_nama = $mapel ? $mapel->nama_matpel : '';
        if ($nilai_rapor >= 90) {
            $capaian = "Menunjukkan penguasaan yang sangat baik dalam memahami materi " . $mapel_nama . ".";
        } elseif ($nilai_rapor >= 75) {
            $capaian = "Menunjukkan penguasaan yang baik dalam memahami materi " . $mapel_nama . ".";
        } else {
            $capaian = "Perlu bimbingan lebih lanjut dalam memahami materi " . $mapel_nama . ".";
        }

        return (object)[
            'nilai_rapor' => $nilai_rapor,
            'capaian_kompetensi' => $capaian
        ];
    }

    public function storeEkskul(Request $request)
    {
        if (!Auth::user()->hasAnyRole(['super admin', 'admin'])) {
            abort(403, 'Akses ditolak.');
        }

        $request->validate([
            'nama_ekstrakurikuler' => 'required|string|max:100',
            'guru_id' => 'required|exists:guru,id',
            'kode_ta' => 'required',
            'kode_unit' => 'required|exists:unit,kode_unit',
        ]);

        \App\Models\Ekstrakurikuler::create([
            'nama_ekstrakurikuler' => $request->nama_ekstrakurikuler,
            'guru_id' => $request->guru_id,
            'kode_ta' => $request->kode_ta,
            'kode_unit' => $request->kode_unit,
        ]);

        return redirect()->back()->with('success', 'Ekstrakurikuler berhasil ditambahkan.');
    }

    public function updateEkskul(Request $request, $id)
    {
        if (!Auth::user()->hasAnyRole(['super admin', 'admin'])) {
            abort(403, 'Akses ditolak.');
        }

        $request->validate([
            'nama_ekstrakurikuler' => 'required|string|max:100',
            'guru_id' => 'required|exists:guru,id',
            'kode_unit' => 'required|exists:unit,kode_unit',
        ]);

        $ekskul = \App\Models\Ekstrakurikuler::findOrFail($id);
        $ekskul->update([
            'nama_ekstrakurikuler' => $request->nama_ekstrakurikuler,
            'guru_id' => $request->guru_id,
            'kode_unit' => $request->kode_unit,
        ]);

        return redirect()->back()->with('success', 'Ekstrakurikuler berhasil diperbarui.');
    }

    public function destroyEkskul($id)
    {
        if (!Auth::user()->hasAnyRole(['super admin', 'admin'])) {
            abort(403, 'Akses ditolak.');
        }

        $ekskul = \App\Models\Ekstrakurikuler::findOrFail($id);
        $ekskul->delete();

        return redirect()->back()->with('success', 'Ekstrakurikuler berhasil dihapus.');
    }

    public function nilaiEkskul($id)
    {
        $ekskul = \App\Models\Ekstrakurikuler::with(['guru.karyawan', 'unit', 'tahunAjaran'])->findOrFail($id);
        
        $user = Auth::user();
        if (!$user->hasAnyRole(['super admin', 'admin'])) {
            $guruModel = \App\Models\Guru::where('npp', $user->npp)->first();
            if (!$guruModel || $ekskul->guru_id != $guruModel->id) {
                abort(403, 'Akses ditolak. Anda bukan koordinator ekstrakurikuler ini.');
            }
        }

        // Fetch all classes of this unit and ta
        $classes = \App\Models\Kelas::where('kode_unit', $ekskul->kode_unit)
            ->where('kode_ta', $ekskul->kode_ta)
            ->get();

        // Fetch students enrolled in this ekskul
        $enrolledStudents = \App\Models\NilaiEkstrakurikuler::with(['siswa'])
            ->where('ekstrakurikuler_id', $id)
            ->get();

        foreach ($enrolledStudents as $enrolled) {
            $kelasSiswa = \App\Models\Kelassiswa::where('id_siswa', $enrolled->id_siswa)
                ->whereHas('kelas', function ($query) use ($ekskul) {
                    $query->where('kode_ta', $ekskul->kode_ta);
                })
                ->first();
            $enrolled->nama_kelas = $kelasSiswa ? $kelasSiswa->kelas->nama_kelas : '-';
        }

        // Available students to enroll from selected class
        $selectedKodeKelas = request('kode_kelas');
        $availableStudents = collect();
        if ($selectedKodeKelas) {
            $enrolledSiswaIds = $enrolledStudents->pluck('id_siswa')->toArray();
            $availableStudents = \App\Models\Kelassiswa::where('kode_kelas', $selectedKodeKelas)
                ->join('siswa', 'kelas_siswa.id_siswa', '=', 'siswa.id_siswa')
                ->whereNotIn('siswa.id_siswa', $enrolledSiswaIds)
                ->select('siswa.id_siswa', 'siswa.nama_lengkap')
                ->orderBy('siswa.nama_lengkap')
                ->get();
        }

        $agent = new \Jenssegers\Agent\Agent();
        if ($agent->isMobile()) {
            return view('akademik.rapor_siswa.nilai_ekskul_mobile', compact('ekskul', 'classes', 'enrolledStudents', 'availableStudents', 'selectedKodeKelas'));
        }

        return view('akademik.rapor_siswa.nilai_ekskul', compact('ekskul', 'classes', 'enrolledStudents', 'availableStudents', 'selectedKodeKelas'));
    }

    public function addSiswaToEkskul(Request $request, $id)
    {
        $ekskul = \App\Models\Ekstrakurikuler::findOrFail($id);

        $user = Auth::user();
        if (!$user->hasAnyRole(['super admin', 'admin'])) {
            $guruModel = \App\Models\Guru::where('npp', $user->npp)->first();
            if (!$guruModel || $ekskul->guru_id != $guruModel->id) {
                abort(403, 'Akses ditolak. Anda bukan koordinator ekstrakurikuler ini.');
            }
        }

        $request->validate([
            'student_ids' => 'required|array',
            'student_ids.*' => 'exists:siswa,id_siswa',
        ]);

        foreach ($request->student_ids as $siswaId) {
            \App\Models\NilaiEkstrakurikuler::firstOrCreate([
                'ekstrakurikuler_id' => $id,
                'id_siswa' => $siswaId,
            ], [
                'nilai' => 'A', // default Very Good
                'keterangan' => 'Sangat Baik dalam mengikuti kegiatan ' . $ekskul->nama_ekstrakurikuler,
            ]);
        }

        return redirect()->back()->with('success', 'Siswa berhasil ditambahkan ke kegiatan ekstrakurikuler.');
    }

    public function saveNilaiEkskul(Request $request, $id)
    {
        $ekskul = \App\Models\Ekstrakurikuler::findOrFail($id);

        $user = Auth::user();
        if (!$user->hasAnyRole(['super admin', 'admin'])) {
            $guruModel = \App\Models\Guru::where('npp', $user->npp)->first();
            if (!$guruModel || $ekskul->guru_id != $guruModel->id) {
                abort(403, 'Akses ditolak. Anda bukan koordinator ekstrakurikuler ini.');
            }
        }

        $request->validate([
            'nilai' => 'required|array',
            'keterangan' => 'required|array',
        ]);

        foreach ($request->nilai as $siswaId => $nilaiVal) {
            \App\Models\NilaiEkstrakurikuler::where('ekstrakurikuler_id', $id)
                ->where('id_siswa', $siswaId)
                ->update([
                    'nilai' => $nilaiVal,
                    'keterangan' => $request->keterangan[$siswaId] ?? null,
                ]);
        }

        return redirect()->back()->with('success', 'Nilai ekstrakurikuler berhasil disimpan.');
    }

    public function removeSiswaFromEkskul($id)
    {
        $nilai = \App\Models\NilaiEkstrakurikuler::with('ekstrakurikuler')->findOrFail($id);

        $user = Auth::user();
        if (!$user->hasAnyRole(['super admin', 'admin'])) {
            $guruModel = \App\Models\Guru::where('npp', $user->npp)->first();
            if (!$guruModel || !$nilai->ekstrakurikuler || $nilai->ekstrakurikuler->guru_id != $guruModel->id) {
                abort(403, 'Akses ditolak. Anda bukan koordinator ekstrakurikuler ini.');
            }
        }

        $nilai->delete();

        return redirect()->back()->with('success', 'Siswa berhasil dihapus dari kegiatan ekstrakurikuler.');
    }
}
