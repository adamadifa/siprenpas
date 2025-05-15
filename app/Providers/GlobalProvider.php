<?php

namespace App\Providers;

use App\Models\Izinabsen;
use App\Models\Izinsakit;
use App\Models\Tahunajaran;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class GlobalProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(Guard $auth): void
    {
        view()->composer('*', function ($view) use ($auth) {
            $notifikasi_izinabsen = Izinabsen::where('status', 0)->count();
            $notifikasi_izinsakit = Izinsakit::where('status', 0)->count();
            $data_izinabsen = Izinabsen::select('presensi_izinabsen.npp', 'nama_lengkap', DB::raw('"i" as status'), 'presensi_izinabsen.created_at')
                ->where('presensi_izinabsen.status', 0)
                ->join('karyawan', 'presensi_izinabsen.npp', '=', 'karyawan.npp');
            $data_izinsakit = Izinsakit::select('presensi_izinsakit.npp', 'nama_lengkap', DB::raw('"s" as status'), 'presensi_izinsakit.created_at')
                ->where('presensi_izinsakit.status', 0)
                ->join('karyawan', 'presensi_izinsakit.npp', '=', 'karyawan.npp');

            $data_izin = $data_izinabsen->unionAll($data_izinsakit)->get();
            $notifikasi_ajuan_absen = $notifikasi_izinabsen  + $notifikasi_izinsakit;
            $listbulan = ['', 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
            $tahunajaran = Tahunajaran::where('status', 1)->first();
            $kode_ta = $tahunajaran->kode_ta;
            $ta_aktif = $tahunajaran->tahun_ajaran;
            $sharedData = [
                'notifikasi_izinabsen' => $notifikasi_izinabsen,
                'notifikasi_izinsakit' => $notifikasi_izinsakit,
                'notifikasi_ajuan_absen' => $notifikasi_ajuan_absen,
                'data_izin' => $data_izin,
                'listbulan' => $listbulan,
                'kode_ta' => $kode_ta,
                'ta_aktif' => $ta_aktif
            ];
            View::share($sharedData);
        });
    }
}
