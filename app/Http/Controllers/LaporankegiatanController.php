<?php

namespace App\Http\Controllers;

use App\Models\Departemen;
use App\Models\Karyawan;
use App\Models\Realisasikegiatan;
use App\Models\User;
use App\Models\Userkaryawan;
use App\Models\Jabatan;
use App\Models\Unit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LaporankegiatanController extends Controller
{
    public function index()
    {
        $user = User::where('id', auth()->user()->id)->first();
        
        $data['list_bulan'] = config('global.list_bulan');
        $data['start_year'] = config('global.start_year');
        
        if ($user->hasRole('karyawan')) {
            $userkaryawan = Userkaryawan::where('id_user', $user->id)->first();
            $data['karyawan'] = Karyawan::where('npp', $userkaryawan->npp)->get();
            $data['departemen'] = Departemen::where('kode_dept', $user->kode_dept)->get();
        } else {
            $data['unit'] = Unit::where('kode_unit', '!=', 'U00')->where('nama_unit', 'not like', '%undefined%')->orderBy('nama_unit')->get();
            $data['karyawan'] = collect();
            $data['departemen'] = collect();
            $data['jabatan'] = collect();
        }

        return view('kegiatan.laporan.index', $data);
    }

    public function cetakrealisasi(Request $request)
    {
        $user = User::where('id', auth()->user()->id)->first();
        
        $query = Realisasikegiatan::query();
        $query->select('realisasi_kegiatan.*', 'name', 'jobdesk', 'program_kerja', 'nama_lengkap');
        $query->join('departemen', 'realisasi_kegiatan.kode_dept', '=', 'departemen.kode_dept');
        $query->join('jabatan', 'realisasi_kegiatan.kode_jabatan', '=', 'jabatan.kode_jabatan');
        $query->leftJoin('jobdesk', 'realisasi_kegiatan.kode_jobdesk', '=', 'jobdesk.kode_jobdesk');
        $query->leftJoin('program_kerja', 'realisasi_kegiatan.kode_program_kerja', '=', 'program_kerja.kode_program_kerja');
        $query->join('users', 'realisasi_kegiatan.id_user', '=', 'users.id');
        $query->join('user_karyawan', 'users.id', '=', 'user_karyawan.id_user');
        $query->join('karyawan', 'user_karyawan.npp', '=', 'karyawan.npp');

        // Date range calculation from Bulan and Tahun or fallback to dari/sampai
        if (!empty($request->bulan) && !empty($request->tahun)) {
            $dari = $request->tahun . '-' . $request->bulan . '-01';
            $sampai = date('Y-m-t', strtotime($dari));
            $query->whereBetween('realisasi_kegiatan.tanggal', [$dari, $sampai]);
        } else {
            $dari = $request->dari;
            $sampai = $request->sampai;
            if (!empty($dari) && !empty($sampai)) {
                $query->whereBetween('realisasi_kegiatan.tanggal', [$dari, $sampai]);
            }
        }

        // Filters based on role and request
        if ($user->hasRole('karyawan')) {
            $query->where('realisasi_kegiatan.id_user', $user->id);
        } else {
            if (!empty($request->npp)) {
                $query->where('karyawan.npp', $request->npp);
            }
            if (!empty($request->kode_unit)) {
                $query->where('karyawan.kode_unit', $request->kode_unit);
            }
            if (!empty($request->kode_dept)) {
                $query->where('realisasi_kegiatan.kode_dept', $request->kode_dept);
            }
            if (!empty($request->kode_jabatan)) {
                $query->where('realisasi_kegiatan.kode_jabatan', $request->kode_jabatan);
            }
        }

        $query->orderBy('realisasi_kegiatan.tanggal', 'desc');
        $data['realisasikegiatan'] = $query->get();
        $data['dari'] = $dari;
        $data['sampai'] = $sampai;

        // Resolve departemen for title
        if ($user->hasRole('karyawan')) {
            $data['departemen'] = Departemen::where('kode_dept', $user->kode_dept)->first();
        } else if (!empty($request->kode_dept)) {
            $data['departemen'] = Departemen::where('kode_dept', $request->kode_dept)->first();
        } else {
            $data['departemen'] = (object) ['nama_dept' => 'SEMUA BIDANG'];
        }

        if ($request->export_excel) {
            header("Content-type: application/vnd-ms-excel");
            header("Content-Disposition: attachment; filename=Laporan_Realisasi_Kegiatan_" . date('YmdHis') . ".xls");
        }

        return view('realisasi_kegiatan.cetak', $data);
    }

    public function getFilterOptions(Request $request)
    {
        $kode_unit = $request->kode_unit;
        $kode_dept = $request->kode_dept;
        $kode_jabatan = $request->kode_jabatan;

        $deptsQuery = Departemen::whereIn('kode_dept', function($q) use ($kode_unit) {
            $q->select('kode_dept')->from('karyawan');
            if (!empty($kode_unit)) {
                $q->where('kode_unit', $kode_unit);
            }
        });
        $departments = $deptsQuery->orderBy('nama_dept')->get();

        $jabsQuery = Jabatan::whereIn('kode_jabatan', function($q) use ($kode_unit, $kode_dept) {
            $q->select('kode_jabatan')->from('karyawan');
            if (!empty($kode_unit)) {
                $q->where('kode_unit', $kode_unit);
            }
            if (!empty($kode_dept)) {
                $q->where('kode_dept', $kode_dept);
            }
        })->where('kode_jabatan', '!=', 'J00');
        $jabatans = $jabsQuery->orderBy('nama_jabatan')->get();

        $karyQuery = Karyawan::query();
        if (!empty($kode_unit)) {
            $karyQuery->where('kode_unit', $kode_unit);
        }
        if (!empty($kode_dept)) {
            $karyQuery->where('kode_dept', $kode_dept);
        }
        if (!empty($kode_jabatan)) {
            $karyQuery->where('kode_jabatan', $kode_jabatan);
        }
        $karyawans = $karyQuery->orderBy('nama_lengkap')->get(['npp', 'nama_lengkap']);

        return response()->json([
            'departments' => $departments,
            'jabatans' => $jabatans,
            'karyawans' => $karyawans
        ]);
    }
}
