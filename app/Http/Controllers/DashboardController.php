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
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {

        $user = User::where('id', auth()->user()->id)->first();
        $hari_ini = date("Y-m-d");
        
        if ($user->hasRole('ketua koperasi')) {
            return view('dashboard.koperasi');
        } else if ($user->hasRole(['admin unit', 'admin tu'])) {
            return view('dashboard.admin_unit');
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
            return view('dashboard.index', $data);
        } else {
            $data['departemen'] = Departemen::orderBy('kode_dept')->get();
            $data['ledger'] = Ledger::orderBy('kode_ledger')->get();
            $hariini = date('Y-m-d');
            $namahari = getnamaHari(date('D', strtotime($hariini)));
            $data['jadwalkerja'] = Karyawan::where('hari_kerja', 'like', '%' . $namahari . '%')->get();
            $data['unit'] = Unit::orderBy('kode_unit')->get();
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
}
