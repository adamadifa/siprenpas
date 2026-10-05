<?php

namespace App\Http\Controllers;

use App\Models\Biayasiswa;
use App\Models\Province;
use App\Models\Siswa;
use App\Models\Tahunajaranppdb;
use App\Models\Unit;
use App\Models\User;
use App\Models\Kelassiswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;

class AkademikSiswaController extends Controller
{
    public function index(Request $request)
    {
        $user = User::where('id', auth()->user()->id)->first();
        $ta_aktif = Tahunajaranppdb::where('status', 1)->first();
        $kode_ta = $ta_aktif->kode_ta ?? null;

        $target_ta = !empty($request->kode_ta) ? $request->kode_ta : $kode_ta;

        $kelas_siswa = Kelassiswa::join('kelas', 'kelas_siswa.kode_kelas', 'kelas.kode_kelas')
            ->select('kelas_siswa.id_siswa', 'nama_kelas')
            ->where('kelas.kode_ta', $target_ta);

        $query = Biayasiswa::query();
        $query->select(
            'siswa.*',
            'pendaftaran.no_pendaftaran',
            'pendaftaran.rfid_code',
            'pendaftaran.foto as foto_pendaftaran',
            'konfigurasi_tahunajaran_ppdb.tahun_ajaran',
            'villages.name as desa',
            'unit.nama_unit',
            'pendaftaran.kode_unit',
            'districts.name as kecamatan',
            'provinces.name as provinsi',
            'regencies.name as kota',
            'unit.logo',
            'pendaftaran.nis',
            'kelas_siswa.nama_kelas',
            'konfigurasi_biaya.tingkat'
        );
        $query->join('pendaftaran', 'siswa_biaya.no_pendaftaran', 'pendaftaran.no_pendaftaran');
        $query->join('siswa', 'pendaftaran.id_siswa', 'siswa.id_siswa');
        $query->join('unit', 'pendaftaran.kode_unit', 'unit.kode_unit');
        $query->join('konfigurasi_biaya', 'siswa_biaya.kode_biaya', 'konfigurasi_biaya.kode_biaya');
        $query->leftjoin('asal_sekolah', 'pendaftaran.kode_asal_sekolah', 'asal_sekolah.kode_asal_sekolah');
        $query->join('konfigurasi_tahunajaran_ppdb', 'konfigurasi_biaya.kode_ta', 'konfigurasi_tahunajaran_ppdb.kode_ta');
        $query->leftJoin('villages', 'siswa.id_village', '=', 'villages.id');
        $query->leftJoin('districts', 'siswa.id_district', '=', 'districts.id');
        $query->leftJoin('provinces', 'siswa.id_province', '=', 'provinces.id');
        $query->leftJoin('regencies', 'siswa.id_regency', '=', 'regencies.id');
        $query->leftJoinSub($kelas_siswa, 'kelas_siswa', function ($join) {
            $join->on('kelas_siswa.id_siswa', '=', 'siswa.id_siswa');
        });

        // Apply search filter across name, nis, nisn, no_pendaftaran, and rfid_code
        if (!empty($request->nama_lengkap)) {
            $search = $request->nama_lengkap;
            $query->where(function ($q) use ($search) {
                $q->where('siswa.nama_lengkap', 'like', '%' . $search . '%')
                  ->orWhere('pendaftaran.no_pendaftaran', 'like', '%' . $search . '%')
                  ->orWhere('pendaftaran.nis', 'like', '%' . $search . '%')
                  ->orWhere('siswa.nisn', 'like', '%' . $search . '%')
                  ->orWhere('pendaftaran.rfid_code', 'like', '%' . $search . '%');
            });
        }

        if (!empty($request->kode_unit)) {
            $query->where('pendaftaran.kode_unit', $request->kode_unit);
        }

        if (!empty($request->kode_ta)) {
            $query->where('konfigurasi_biaya.kode_ta', $request->kode_ta);
        } else {
            $query->where('konfigurasi_biaya.kode_ta', $kode_ta);
        }

        if (!empty($request->tingkat)) {
            $query->where('konfigurasi_biaya.tingkat', $request->tingkat);
        }

        if (!empty($request->kode_kelas)) {
            $query->where('kelas_siswa.kode_kelas', $request->kode_kelas);
        }

        if ($user->kode_unit != 'U06') {
            $query->where('pendaftaran.kode_unit', $user->kode_unit);
        }

        $query->orderBy('siswa.nama_lengkap');
        $siswa = $query->paginate(25);
        $siswa->appends($request->all());

        // Executive Statistics query
        $statsQuery = DB::table('siswa_biaya')
            ->join('pendaftaran', 'siswa_biaya.no_pendaftaran', '=', 'pendaftaran.no_pendaftaran')
            ->join('siswa', 'pendaftaran.id_siswa', '=', 'siswa.id_siswa')
            ->join('konfigurasi_biaya', 'siswa_biaya.kode_biaya', '=', 'konfigurasi_biaya.kode_biaya')
            ->leftJoinSub($kelas_siswa, 'kelas_siswa', function ($join) {
                $join->on('kelas_siswa.id_siswa', '=', 'siswa.id_siswa');
            })
            ->where('konfigurasi_biaya.kode_ta', $target_ta);

        if ($user->kode_unit != 'U06') {
            $statsQuery->where('pendaftaran.kode_unit', $user->kode_unit);
        }

        if (!empty($request->kode_unit)) {
            $statsQuery->where('pendaftaran.kode_unit', $request->kode_unit);
        }

        if (!empty($request->tingkat)) {
            $statsQuery->where('konfigurasi_biaya.tingkat', $request->tingkat);
        }

        $statsRaw = (clone $statsQuery)->selectRaw("
            COUNT(DISTINCT pendaftaran.no_pendaftaran) as total_siswa,
            COUNT(DISTINCT CASE WHEN siswa.jenis_kelamin = 'L' THEN pendaftaran.no_pendaftaran END) as total_laki,
            COUNT(DISTINCT CASE WHEN siswa.jenis_kelamin = 'P' THEN pendaftaran.no_pendaftaran END) as total_perempuan,
            COUNT(DISTINCT CASE WHEN kelas_siswa.nama_kelas IS NOT NULL THEN pendaftaran.no_pendaftaran END) as sudah_kelas,
            COUNT(DISTINCT CASE WHEN pendaftaran.rfid_code IS NOT NULL AND pendaftaran.rfid_code != '' THEN pendaftaran.no_pendaftaran END) as rfid_ready
        ")->first();

        $stats = [
            'total_siswa' => $statsRaw->total_siswa ?? 0,
            'total_laki' => $statsRaw->total_laki ?? 0,
            'total_perempuan' => $statsRaw->total_perempuan ?? 0,
            'sudah_kelas' => $statsRaw->sudah_kelas ?? 0,
            'belum_kelas' => ($statsRaw->total_siswa ?? 0) - ($statsRaw->sudah_kelas ?? 0),
            'rfid_ready' => $statsRaw->rfid_ready ?? 0,
        ];

        // Unit breakdown statistics
        $unitSubQuery = DB::table('siswa_biaya')
            ->join('pendaftaran', 'siswa_biaya.no_pendaftaran', '=', 'pendaftaran.no_pendaftaran')
            ->join('siswa', 'pendaftaran.id_siswa', '=', 'siswa.id_siswa')
            ->join('konfigurasi_biaya', 'siswa_biaya.kode_biaya', '=', 'konfigurasi_biaya.kode_biaya')
            ->select('pendaftaran.kode_unit', 'siswa_biaya.no_pendaftaran')
            ->where('konfigurasi_biaya.kode_ta', $target_ta);

        if (!empty($request->nama_lengkap)) {
            $search = $request->nama_lengkap;
            $unitSubQuery->where(function ($q) use ($search) {
                $q->where('siswa.nama_lengkap', 'like', '%' . $search . '%')
                  ->orWhere('pendaftaran.no_pendaftaran', 'like', '%' . $search . '%')
                  ->orWhere('pendaftaran.nis', 'like', '%' . $search . '%')
                  ->orWhere('siswa.nisn', 'like', '%' . $search . '%')
                  ->orWhere('pendaftaran.rfid_code', 'like', '%' . $search . '%');
            });
        }

        if (!empty($request->tingkat)) {
            $unitSubQuery->where('konfigurasi_biaya.tingkat', $request->tingkat);
        }

        $rekap_unit = DB::table('unit')
            ->leftJoinSub($unitSubQuery, 'filtered_pendaftaran', function ($join) {
                $join->on('unit.kode_unit', '=', 'filtered_pendaftaran.kode_unit');
            })
            ->select('unit.nama_unit', 'unit.kode_unit', DB::raw('count(filtered_pendaftaran.no_pendaftaran) as jumlah'))
            ->groupBy('unit.nama_unit', 'unit.kode_unit')
            ->whereNotIn('unit.kode_unit', ['U00', 'U06'])
            ->orderBy('unit.kode_unit')
            ->get();

        $data['pendaftaran'] = $siswa;
        $data['rekap_unit'] = $rekap_unit;
        $data['stats'] = $stats;
        $data['tahun_ajaran'] = $ta_aktif;
        $data['selected_ta'] = $target_ta;
        $u = new Unit();
        $data['unit'] = $u->getUnit();
        $data['jenis_kelamin'] = config('global.jenis_kelamin');
        $data['tahunajaran'] = Tahunajaranppdb::orderBy('kode_ta', 'desc')->get();

        return view('akademik.siswa.index', $data);
    }
}
