<?php

namespace App\Http\Controllers;

use App\Models\Agendakegiatan;
use App\Models\Departemen;
use App\Models\Karyawan;
use App\Models\Karyawananggota;
use App\Models\Ledger;
use App\Models\Presensi;
use App\Models\Realisasikegiatan;
use App\Models\Unit;
use App\Models\User;
use App\Models\Userkaryawan;
use App\Models\Tahunajaran;
use App\Models\PengaturanUmum;
use App\Models\Kelas;
use App\Models\MataPelajaran;
use App\Models\JadwalPelajaran;
use App\Models\Siswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {

        $user = User::where('id', auth()->user()->id)->first();
        $hari_ini = date("Y-m-d");

        $tahunajaran = Tahunajaran::orderBy('kode_ta', 'desc')->get();
        $activeTa = Tahunajaran::where('status', '1')->first() ?? $tahunajaran->first();
        $pengaturan = PengaturanUmum::first();

        $unitsQuery = Unit::whereNotIn('kode_unit', ['U00', 'U06', 'U07'])->orderBy('kode_unit');
        if ($user->kode_unit != 'U06' && !empty($user->kode_unit)) {
            $units = Unit::where('kode_unit', $user->kode_unit)->get();
        } else {
            $units = $unitsQuery->get();
        }
        
        if ($user->hasRole('ketua koperasi')) {
            return view('dashboard.koperasi');
        } else if ($user->hasRole(['admin unit', 'admin tu'])) {
            return view('dashboard.admin_unit', compact('tahunajaran', 'activeTa', 'pengaturan', 'units'));
        } else if ($user->hasRole('guru')) {
            $agent = new \Jenssegers\Agent\Agent();
            $guru = \App\Models\Guru::with('karyawan')->where('npp', $user->npp)->first();

            if ($guru && $agent->isMobile()) {
                $activeTa = \App\Models\Tahunajaran::where('status', '1')->first();
                $activeSemester = \App\Models\Semester::where('status', '1')->first();
                $selectedSemester = $activeSemester ? $activeSemester->semester : '1';

                // Hari ini dalam bahasa Indonesia
                $hariIni = getHari(date('Y-m-d'));

                // Jadwal mengajar hari ini
                $jadwalHariIni = collect();
                if ($activeTa) {
                    $jadwalHariIni = \App\Models\JadwalPelajaran::with(['mapel', 'kelas'])
                        ->where('guru_id', $guru->id)
                        ->where('kode_ta', $activeTa->kode_ta)
                        ->where('semester', $selectedSemester)
                        ->where('hari', $hariIni)
                        ->orderBy('jam_ke')
                        ->get();
                }

                // Cek status presensi hari ini per jadwal
                $jadwalHariIni->each(function ($jadwal) {
                    $jadwal->sudah_presensi = \App\Models\PresensiMapel::where('jadwal_pelajaran_id', $jadwal->id)
                        ->where('tanggal', date('Y-m-d'))
                        ->exists();
                });

                // Kelas binaan (wali kelas)
                $listKelasBinaan = collect();
                $kelasBinaan = null;
                $totalSiswa = 0;
                if ($activeTa) {
                    $listKelasBinaan = \App\Models\Kelas::with('unit')
                        ->where('guru_id', $guru->id)
                        ->where('kode_ta', $activeTa->kode_ta)
                        ->get();

                    $kelasBinaan = $listKelasBinaan->first();

                    if ($listKelasBinaan->isNotEmpty()) {
                        $kodeKelasList = $listKelasBinaan->pluck('kode_kelas')->toArray();
                        $totalSiswa = \App\Models\Kelassiswa::whereIn('kode_kelas', $kodeKelasList)->count();
                    }
                }

                // Sapaan kontekstual
                $jam = (int) date('H');
                if ($jam >= 3 && $jam < 11) {
                    $sapaan = 'Selamat Pagi';
                } elseif ($jam >= 11 && $jam < 15) {
                    $sapaan = 'Selamat Siang';
                } elseif ($jam >= 15 && $jam < 18) {
                    $sapaan = 'Selamat Sore';
                } else {
                    $sapaan = 'Selamat Malam';
                }

                $isKoordinator = false;
                if ($activeTa) {
                    $isKoordinator = \App\Models\Ekstrakurikuler::where('guru_id', $guru->id)
                        ->where('kode_ta', $activeTa->kode_ta)
                        ->exists();
                }

                return view('dashboard.guru_mobile', compact(
                    'guru',
                    'activeTa',
                    'jadwalHariIni',
                    'kelasBinaan',
                    'listKelasBinaan',
                    'totalSiswa',
                    'hariIni',
                    'sapaan',
                    'isKoordinator'
                ));
            }

            // Desktop fallback — gunakan dashboard default
            $data['departemen'] = Departemen::orderBy('kode_dept')->get();
            $data['ledger'] = Ledger::orderBy('kode_ledger')->get();
            $hariini = date('Y-m-d');
            $namahari = getnamaHari(date('D', strtotime($hariini)));
            $data['jadwalkerja'] = Karyawan::where('hari_kerja', 'like', '%' . $namahari . '%')->get();
            $data['unit'] = Unit::orderBy('kode_unit')->get();
            $data['tahunajaran'] = $tahunajaran;
            $data['activeTa'] = $activeTa;
            $data['pengaturan'] = $pengaturan;
            $data['units'] = $units;
            return view('dashboard.index', $data);
        } else {
            $data['departemen'] = Departemen::orderBy('kode_dept')->get();
            $data['ledger'] = Ledger::orderBy('kode_ledger')->get();
            $hariini = date('Y-m-d');
            $namahari = getnamaHari(date('D', strtotime($hariini)));
            $data['jadwalkerja'] = Karyawan::where('hari_kerja', 'like', '%' . $namahari . '%')->get();
            $data['unit'] = Unit::orderBy('kode_unit')->get();
            $data['tahunajaran'] = $tahunajaran;
            $data['activeTa'] = $activeTa;
            $data['pengaturan'] = $pengaturan;
            $data['units'] = $units;
            return view('dashboard.index', $data);
        }
    }

    public function guruDashboard()
    {
        $user = auth()->user();
        $npp = $user->npp;
        $guru = \App\Models\Guru::with('karyawan')->where('npp', $npp)->first();

        if (!$guru) {
            return redirect('/dashboard')->with(messageError('Anda tidak terdaftar sebagai guru.'));
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
                ->get();
        }

        $jadwalHariIni->each(function ($jadwal) {
            $jadwal->sudah_presensi = \App\Models\PresensiMapel::where('jadwal_pelajaran_id', $jadwal->id)
                ->where('tanggal', date('Y-m-d'))
                ->exists();
        });

        $listKelasBinaan = collect();
        $kelasBinaan = null;
        $totalSiswa = 0;
        if ($activeTa) {
            $listKelasBinaan = \App\Models\Kelas::with('unit')
                ->where('guru_id', $guru->id)
                ->where('kode_ta', $activeTa->kode_ta)
                ->get();

            $kelasBinaan = $listKelasBinaan->first();

            if ($listKelasBinaan->isNotEmpty()) {
                $kodeKelasList = $listKelasBinaan->pluck('kode_kelas')->toArray();
                $totalSiswa = \App\Models\Kelassiswa::whereIn('kode_kelas', $kodeKelasList)->count();
            }
        }

        $jam = (int) date('H');
        if ($jam >= 3 && $jam < 11) {
            $sapaan = 'Selamat Pagi';
        } elseif ($jam >= 11 && $jam < 15) {
            $sapaan = 'Selamat Siang';
        } elseif ($jam >= 15 && $jam < 18) {
            $sapaan = 'Selamat Sore';
        } else {
            $sapaan = 'Selamat Malam';
        }

        $isKoordinator = false;
        if ($activeTa) {
            $isKoordinator = \App\Models\Ekstrakurikuler::where('guru_id', $guru->id)
                ->where('kode_ta', $activeTa->kode_ta)
                ->exists();
        }

        $pengaturan = \App\Models\Pengaturanumum::first();

        $agent = new \Jenssegers\Agent\Agent();
        if ($agent->isMobile()) {
            return view('dashboard.guru_mobile', compact(
                'guru',
                'activeTa',
                'jadwalHariIni',
                'kelasBinaan',
                'listKelasBinaan',
                'totalSiswa',
                'hariIni',
                'sapaan',
                'isKoordinator',
                'pengaturan'
            ));
        }

        return view('dashboard.guru', compact(
            'guru',
            'activeTa',
            'jadwalHariIni',
            'kelasBinaan',
            'listKelasBinaan',
            'totalSiswa',
            'hariIni',
            'sapaan',
            'isKoordinator'
        ));
    }

    public function getrealisasikegiatan(Request $request)
    {
        //Dashboard
        $user = User::where('id', auth()->user()->id)->first();
        $dari = $request->dari;
        $sampai = $request->sampai;
        $kode_dept = $request->kode_dept;
        $query = Realisasikegiatan::query();
        $query->select('realisasi_kegiatan.*', 'name', 'jobdesk', 'nama_dept');
        $query->join('departemen', 'realisasi_kegiatan.kode_dept', '=', 'departemen.kode_dept');
        $query->join('jabatan', 'realisasi_kegiatan.kode_jabatan', '=', 'jabatan.kode_jabatan');
        $query->join('jobdesk', 'realisasi_kegiatan.kode_jobdesk', '=', 'jobdesk.kode_jobdesk');
        $query->join('users', 'realisasi_kegiatan.id_user', '=', 'users.id');
        if (!empty($kode_dept)) {
            $query->where('realisasi_kegiatan.kode_dept', $kode_dept);
        } else {
            $query->where('realisasi_kegiatan.kode_dept', $user->kode_dept);
        }
        // if ($user->hasRole('super admin')) {
        // } else {
        //     $query->where('realisasi_kegiatan.kode_jabatan', $user->kode_jabatan);
        //     $query->where('realisasi_kegiatan.kode_dept', $user->kode_dept);
        //     $query->where('realisasi_kegiatan.id_user', auth()->user()->id);
        // }
        $query->whereBetween('realisasi_kegiatan.tanggal', [$dari, $sampai]);

        $query->orderBy('tanggal');
        $data['realisasikegiatan'] = $query->get();
        return view('dashboard.getrealisasikegiatan', $data);
    }

    public function getagendakegiatan(Request $request)
    {
        $user = User::where('id', auth()->user()->id)->first();
        $dari = $request->dari;
        $sampai = $request->sampai;
        $kode_dept = $request->kode_dept;
        $query = Agendakegiatan::query();
        $query->select('agenda_kegiatan.*', 'name', 'nama_dept');
        $query->join('departemen', 'agenda_kegiatan.kode_dept', '=', 'departemen.kode_dept');
        $query->join('jabatan', 'agenda_kegiatan.kode_jabatan', '=', 'jabatan.kode_jabatan');
        $query->join('users', 'agenda_kegiatan.id_user', '=', 'users.id');
        if (!empty($kode_dept)) {
            $query->where('agenda_kegiatan.kode_dept', $kode_dept);
        } else {
            // $query->where('agenda_kegiatan.kode_jabatan', $user->kode_jabatan);
            $query->where('agenda_kegiatan.kode_dept', $user->kode_dept);
            // $query->where('agenda_kegiatan.id_user', auth()->user()->id);
        }
        // if ($user->hasRole('super admin')) {

        // } else {
        //     $query->where('agenda_kegiatan.kode_jabatan', $user->kode_jabatan);
        //     $query->where('agenda_kegiatan.kode_dept', $user->kode_dept);
        //     $query->where('agenda_kegiatan.id_user', auth()->user()->id);
        // }
        $query->whereBetween('agenda_kegiatan.tanggal', [$dari, $sampai]);

        $query->orderBy('tanggal');
        $data['agendakegiatan'] = $query->get();
        return view('dashboard.getagendakegiatan', $data);
    }

    public function getReportKelengkapan(Request $request)
    {
        $user = auth()->user();
        $activeTa = Tahunajaran::where('status', '1')->first();
        $kode_ta = $request->kode_ta ?: ($activeTa ? $activeTa->kode_ta : 'TA2627');
        $selectedTa = Tahunajaran::where('kode_ta', $kode_ta)->first();

        // Units query
        $unitQuery = Unit::whereNotIn('kode_unit', ['U00', 'U06', 'U07'])->orderBy('kode_unit');
        if ($user->kode_unit != 'U06' && !empty($user->kode_unit)) {
            $unitQuery->where('kode_unit', $user->kode_unit);
        } elseif (!empty($request->kode_unit)) {
            $unitQuery->where('kode_unit', $request->kode_unit);
        }
        $units = $unitQuery->get();

        $reportData = [];
        $totalAllMapel = 0;
        $totalAllMapelAktif = 0;
        $totalAllKelas = 0;
        $totalAllKelasJadwal = 0;
        $totalAllJadwalSesi = 0;
        $totalAllSantri = 0;
        $totalAllSantriLengkap = 0;
        $totalAllSantriPlotted = 0;

        foreach ($units as $u) {
            // 1. Mata Pelajaran
            $mapelTotal = DB::table('mata_pelajaran')->where('kode_unit', $u->kode_unit)->count();
            $mapelAktif = DB::table('mata_pelajaran')->where('kode_unit', $u->kode_unit)->where('aktif', 1)->count();
            
            // 2. Kelas & Jadwal Pelajaran
            $kelas = DB::table('kelas')->where('kode_unit', $u->kode_unit)->where('kode_ta', $kode_ta)->get();
            $totalKelas = $kelas->count();
            $kelasIds = $kelas->pluck('kode_kelas')->toArray();
            $kelasDenganJadwal = 0;
            $totalJadwalSesi = 0;
            if (!empty($kelasIds)) {
                $kelasDenganJadwal = DB::table('jadwal_pelajaran')
                    ->where('kode_ta', $kode_ta)
                    ->whereIn('kode_kelas', $kelasIds)
                    ->distinct()
                    ->count('kode_kelas');
                $totalJadwalSesi = DB::table('jadwal_pelajaran')
                    ->where('kode_ta', $kode_ta)
                    ->whereIn('kode_kelas', $kelasIds)
                    ->count();
            }

            // 3. Santri, Kelengkapan Data & Ploting Kelas
            $kelasSiswaTa = DB::table('kelas_siswa')
                ->join('kelas', 'kelas_siswa.kode_kelas', '=', 'kelas.kode_kelas')
                ->where('kelas.kode_ta', $kode_ta)
                ->select('kelas_siswa.id_siswa', 'kelas.kode_kelas', 'kelas.nama_kelas');

            $students = DB::table('siswa_biaya')
                ->join('konfigurasi_biaya', 'siswa_biaya.kode_biaya', '=', 'konfigurasi_biaya.kode_biaya')
                ->join('pendaftaran', 'siswa_biaya.no_pendaftaran', '=', 'pendaftaran.no_pendaftaran')
                ->join('siswa', 'pendaftaran.id_siswa', '=', 'siswa.id_siswa')
                ->leftJoinSub($kelasSiswaTa, 'ks', function($join) {
                    $join->on('siswa.id_siswa', '=', 'ks.id_siswa');
                })
                ->where('konfigurasi_biaya.kode_ta', $kode_ta)
                ->where('pendaftaran.kode_unit', $u->kode_unit)
                ->where('pendaftaran.status_siswa', 1)
                ->select(
                    'siswa.id_siswa',
                    'siswa.nama_lengkap',
                    'siswa.jenis_kelamin',
                    'siswa.tempat_lahir',
                    'siswa.tanggal_lahir',
                    'siswa.nisn',
                    'siswa.no_kk',
                    'siswa.nama_ayah',
                    'siswa.nama_ibu',
                    'siswa.nik_ayah',
                    'siswa.nik_ibu',
                    'siswa.pendidikan_ayah',
                    'siswa.pekerjaan_ayah',
                    'siswa.pendidikan_ibu',
                    'siswa.pekerjaan_ibu',
                    'siswa.no_hp_orang_tua',
                    'siswa.alamat',
                    'siswa.id_province',
                    'siswa.id_regency',
                    'siswa.id_district',
                    'siswa.id_village',
                    'siswa.kode_pos',
                    'pendaftaran.foto as foto_pendaftaran',
                    'pendaftaran.nis',
                    'ks.kode_kelas',
                    'ks.nama_kelas'
                )
                ->get()
                ->unique('id_siswa');

            $totalSantri = $students->count();
            $santriLengkap = 0;
            $santriPlotted = 0;

            foreach ($students as $s) {
                // Evaluasi kelengkapan SEMUA field (Identitas, Wilayah, Ortu, Dokumen)
                $isLengkap = !empty($s->nama_lengkap) &&
                             !empty($s->jenis_kelamin) &&
                             !empty($s->tempat_lahir) &&
                             !empty($s->tanggal_lahir) &&
                             !empty($s->nisn) &&
                             !empty($s->no_kk) && 
                             !empty($s->alamat) &&
                             !empty($s->id_province) &&
                             !empty($s->id_regency) &&
                             !empty($s->id_district) &&
                             !empty($s->id_village) &&
                             !empty($s->nama_ayah) && 
                             !empty($s->nik_ayah) &&
                             !empty($s->nama_ibu) && 
                             !empty($s->nik_ibu) &&
                             !empty($s->no_hp_orang_tua) &&
                             !empty($s->foto_pendaftaran);

                if ($isLengkap) {
                    $santriLengkap++;
                }
                if (!empty($s->kode_kelas)) {
                    $santriPlotted++;
                }
            }

            // Setting jadwal hanya berlaku untuk SDIT (U03), MTs (U04), dan MA (U05)
            $hasJadwal = in_array($u->kode_unit, ['U03', 'U04', 'U05']);

            // Hitung skor kesiapan unit (0 - 100)
            $scoreMapel = ($mapelAktif > 0) ? min(100, ($mapelAktif / 10) * 100) : 0;
            $scoreSantri = ($totalSantri > 0) ? ($santriLengkap / $totalSantri) * 100 : 0;
            $scorePloting = ($totalSantri > 0) ? ($santriPlotted / $totalSantri) * 100 : 0;

            if ($hasJadwal) {
                $scoreJadwal = ($totalKelas > 0) ? ($kelasDenganJadwal / $totalKelas) * 100 : 0;
                $overallScore = round(
                    ($scoreMapel * 0.20) + 
                    ($scoreJadwal * 0.30) + 
                    ($scoreSantri * 0.25) + 
                    ($scorePloting * 0.25)
                );
            } else {
                // Untuk unit tanpa jadwal (TK, Diniyah, dll), bobot dialihkan ke 3 aspek lain
                $overallScore = round(
                    ($scoreMapel * 0.30) + 
                    ($scoreSantri * 0.35) + 
                    ($scorePloting * 0.35)
                );
            }

            $reportData[] = [
                'unit' => $u,
                'has_jadwal' => $hasJadwal,
                'mapel' => [
                    'total' => $mapelTotal,
                    'aktif' => $mapelAktif,
                    'status' => $mapelAktif > 0 ? 'Siap' : 'Belum Ada'
                ],
                'jadwal' => [
                    'total_kelas' => $totalKelas,
                    'kelas_terjadwal' => $kelasDenganJadwal,
                    'total_sesi' => $totalJadwalSesi,
                    'persen' => $totalKelas > 0 ? round(($kelasDenganJadwal / $totalKelas) * 100) : 0
                ],
                'santri' => [
                    'total' => $totalSantri,
                    'lengkap' => $santriLengkap,
                    'belum_lengkap' => $totalSantri - $santriLengkap,
                    'persen' => $totalSantri > 0 ? round(($santriLengkap / $totalSantri) * 100) : 0
                ],
                'ploting' => [
                    'total' => $totalSantri,
                    'plotted' => $santriPlotted,
                    'belum_plotted' => $totalSantri - $santriPlotted,
                    'persen' => $totalSantri > 0 ? round(($santriPlotted / $totalSantri) * 100) : 0
                ],
                'overall_score' => $overallScore,
            ];

            $totalAllMapel += $mapelTotal;
            $totalAllMapelAktif += $mapelAktif;
            $totalAllKelas += $totalKelas;
            $totalAllKelasJadwal += $kelasDenganJadwal;
            $totalAllJadwalSesi += $totalJadwalSesi;
            $totalAllSantri += $totalSantri;
            $totalAllSantriLengkap += $santriLengkap;
            $totalAllSantriPlotted += $santriPlotted;
        }

        $summary = [
            'total_mapel' => $totalAllMapel,
            'total_mapel_aktif' => $totalAllMapelAktif,
            'total_kelas' => $totalAllKelas,
            'total_kelas_jadwal' => $totalAllKelasJadwal,
            'total_jadwal_sesi' => $totalAllJadwalSesi,
            'persen_jadwal' => $totalAllKelas > 0 ? round(($totalAllKelasJadwal / $totalAllKelas) * 100) : 0,
            'total_santri' => $totalAllSantri,
            'total_santri_lengkap' => $totalAllSantriLengkap,
            'total_santri_belum_lengkap' => $totalAllSantri - $totalAllSantriLengkap,
            'persen_santri_lengkap' => $totalAllSantri > 0 ? round(($totalAllSantriLengkap / $totalAllSantri) * 100) : 0,
            'total_santri_plotted' => $totalAllSantriPlotted,
            'total_santri_belum_plotted' => $totalAllSantri - $totalAllSantriPlotted,
            'persen_santri_plotted' => $totalAllSantri > 0 ? round(($totalAllSantriPlotted / $totalAllSantri) * 100) : 0,
        ];

        return view('dashboard.get_report_kelengkapan', compact('reportData', 'summary', 'kode_ta', 'selectedTa', 'units'));
    }

    public function getDetailSantriBelumLengkap(Request $request)
    {
        $kode_unit = $request->kode_unit;
        $kode_ta = $request->kode_ta;
        $unit = Unit::where('kode_unit', $kode_unit)->first();
        $ta = Tahunajaran::where('kode_ta', $kode_ta)->first();

        $students = DB::table('siswa_biaya')
            ->join('konfigurasi_biaya', 'siswa_biaya.kode_biaya', '=', 'konfigurasi_biaya.kode_biaya')
            ->join('pendaftaran', 'siswa_biaya.no_pendaftaran', '=', 'pendaftaran.no_pendaftaran')
            ->join('siswa', 'pendaftaran.id_siswa', '=', 'siswa.id_siswa')
            ->where('konfigurasi_biaya.kode_ta', $kode_ta)
            ->where('pendaftaran.kode_unit', $kode_unit)
            ->where('pendaftaran.status_siswa', 1)
            ->select(
                'siswa.id_siswa',
                'siswa.nama_lengkap',
                'siswa.jenis_kelamin',
                'siswa.tempat_lahir',
                'siswa.tanggal_lahir',
                'siswa.nisn',
                'siswa.no_kk',
                'siswa.nama_ayah',
                'siswa.nama_ibu',
                'siswa.nik_ayah',
                'siswa.nik_ibu',
                'siswa.pendidikan_ayah',
                'siswa.pekerjaan_ayah',
                'siswa.pendidikan_ibu',
                'siswa.pekerjaan_ibu',
                'siswa.no_hp_orang_tua',
                'siswa.alamat',
                'siswa.id_province',
                'siswa.id_regency',
                'siswa.id_district',
                'siswa.id_village',
                'siswa.kode_pos',
                'pendaftaran.foto as foto_pendaftaran',
                'pendaftaran.nis',
                'pendaftaran.no_pendaftaran'
            )
            ->get()
            ->unique('id_siswa');

        $listBelumLengkap = $students->filter(function($s) {
            $isLengkap = !empty($s->nama_lengkap) &&
                         !empty($s->jenis_kelamin) &&
                         !empty($s->tempat_lahir) &&
                         !empty($s->tanggal_lahir) &&
                         !empty($s->nisn) &&
                         !empty($s->no_kk) && 
                         !empty($s->alamat) &&
                         !empty($s->id_province) &&
                         !empty($s->id_regency) &&
                         !empty($s->id_district) &&
                         !empty($s->id_village) &&
                         !empty($s->nama_ayah) && 
                         !empty($s->nik_ayah) &&
                         !empty($s->nama_ibu) && 
                         !empty($s->nik_ibu) &&
                         !empty($s->no_hp_orang_tua) &&
                         !empty($s->foto_pendaftaran);
            return !$isLengkap;
        });

        return view('dashboard.modal_detail_santri_belum_lengkap', compact('listBelumLengkap', 'unit', 'ta'));
    }

    public function getDetailSantriBelumPlot(Request $request)
    {
        $kode_unit = $request->kode_unit;
        $kode_ta = $request->kode_ta;
        $unit = Unit::where('kode_unit', $kode_unit)->first();
        $ta = Tahunajaran::where('kode_ta', $kode_ta)->first();

        $students = DB::table('siswa_biaya')
            ->join('konfigurasi_biaya', 'siswa_biaya.kode_biaya', '=', 'konfigurasi_biaya.kode_biaya')
            ->join('pendaftaran', 'siswa_biaya.no_pendaftaran', '=', 'pendaftaran.no_pendaftaran')
            ->join('siswa', 'pendaftaran.id_siswa', '=', 'siswa.id_siswa')
            ->where('konfigurasi_biaya.kode_ta', $kode_ta)
            ->where('pendaftaran.kode_unit', $kode_unit)
            ->where('pendaftaran.status_siswa', 1)
            ->whereNotExists(function ($query) use ($kode_ta) {
                $query->select(DB::raw(1))
                    ->from('kelas_siswa')
                    ->join('kelas', 'kelas_siswa.kode_kelas', '=', 'kelas.kode_kelas')
                    ->whereColumn('kelas_siswa.id_siswa', 'siswa.id_siswa')
                    ->where('kelas.kode_ta', $kode_ta);
            })
            ->select(
                'siswa.id_siswa',
                'siswa.nama_lengkap',
                'siswa.jenis_kelamin',
                'pendaftaran.foto as foto_pendaftaran',
                'pendaftaran.nis',
                'pendaftaran.no_pendaftaran',
                'pendaftaran.kode_unit',
                'konfigurasi_biaya.tingkat'
            )
            ->get()
            ->unique('id_siswa');

        $kelasList = Kelas::where('kode_unit', $kode_unit)
            ->where('kode_ta', $kode_ta)
            ->with(['waliKelas.karyawan'])
            ->orderBy('tingkat')
            ->orderBy('nama_kelas')
            ->get();

        return view('dashboard.modal_detail_santri_belum_plot', compact('students', 'unit', 'ta', 'kelasList'));
    }

    public function getDetailJadwalKelas(Request $request)
    {
        $kode_unit = $request->kode_unit;
        $kode_ta = $request->kode_ta;
        $unit = Unit::where('kode_unit', $kode_unit)->first();
        $ta = Tahunajaran::where('kode_ta', $kode_ta)->first();

        $kelasList = \App\Models\Kelas::where('kode_unit', $kode_unit)
            ->where('kode_ta', $kode_ta)
            ->with(['waliKelas.karyawan'])
            ->get();

        foreach ($kelasList as $k) {
            $k->total_jadwal = DB::table('jadwal_pelajaran')
                ->where('kode_ta', $kode_ta)
                ->where('kode_kelas', $k->kode_kelas)
                ->count();
            $k->total_mapel = DB::table('jadwal_pelajaran')
                ->where('kode_ta', $kode_ta)
                ->where('kode_kelas', $k->kode_kelas)
                ->distinct()
                ->count('mata_pelajaran_id');
            $k->total_siswa = DB::table('kelas_siswa')
                ->where('kode_kelas', $k->kode_kelas)
                ->count();
        }

        return view('dashboard.modal_detail_jadwal_kelas', compact('kelasList', 'unit', 'ta'));
    }
}
