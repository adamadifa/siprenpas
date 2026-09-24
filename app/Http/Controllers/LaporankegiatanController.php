<?php

namespace App\Http\Controllers;

use App\Models\Agendakegiatan;
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
        
        $accessibleUnits = $user->getAccessibleUnitCodes();
        $accessibleDepts = $user->getAccessibleDeptCodes();

        // Cek apakah user memiliki hak akses laporan menyeluruh (super admin atau punya permission realkegiatan.laporan atau multi unit/dept)
        $canFilterAll = $user->hasRole('super admin') || $user->can('realkegiatan.laporan') || count($accessibleDepts) > 1 || count($accessibleUnits) > 1;

        if ($user->hasRole('karyawan') && !$canFilterAll) {
            $userkaryawan = Userkaryawan::where('id_user', $user->id)->first();
            $data['karyawan'] = Karyawan::where('npp', $userkaryawan->npp)->get();
            $data['departemen'] = Departemen::where('kode_dept', $user->kode_dept)->get();
            $data['can_filter_all'] = false;
        } else {
            $unitModel = new Unit();
            $data['unit'] = $unitModel->getUnit();
            $data['karyawan'] = collect();
            $data['departemen'] = collect();
            $data['jabatan'] = collect();
            $data['can_filter_all'] = true;
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

        $accessibleUnits = $user->getAccessibleUnitCodes();
        $accessibleDepts = $user->getAccessibleDeptCodes();
        $canFilterAll = $user->hasRole('super admin') || $user->can('realkegiatan.laporan') || count($accessibleDepts) > 1 || count($accessibleUnits) > 1;

        // Filters based on role and request
        if ($user->hasRole('karyawan') && !$canFilterAll) {
            $query->where('realisasi_kegiatan.id_user', $user->id);
        } else {
            if (!$user->hasRole('super admin')) {
                $query->whereIn('realisasi_kegiatan.kode_dept', $accessibleDepts);
                $query->whereIn('karyawan.kode_unit', $accessibleUnits);
            }

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
        if ($user->hasRole('karyawan') && !$canFilterAll) {
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

    public function cetakagenda(Request $request)
    {
        $user = User::where('id', auth()->user()->id)->first();
        
        $query = Agendakegiatan::query();
        $query->select('agenda_kegiatan.*', 'users.name', 'departemen.nama_dept', 'jabatan.nama_jabatan');
        $query->join('departemen', 'agenda_kegiatan.kode_dept', '=', 'departemen.kode_dept');
        $query->join('jabatan', 'agenda_kegiatan.kode_jabatan', '=', 'jabatan.kode_jabatan');
        $query->join('users', 'agenda_kegiatan.id_user', '=', 'users.id');
        $query->leftJoin('user_karyawan', 'users.id', '=', 'user_karyawan.id_user');
        $query->leftJoin('karyawan', 'user_karyawan.npp', '=', 'karyawan.npp');

        // Date range calculation from Bulan and Tahun or fallback to dari/sampai
        if (!empty($request->bulan) && !empty($request->tahun)) {
            $dari = $request->tahun . '-' . $request->bulan . '-01';
            $sampai = date('Y-m-t', strtotime($dari));
            $query->whereBetween('agenda_kegiatan.tanggal', [$dari, $sampai]);
        } else {
            $dari = $request->dari;
            $sampai = $request->sampai;
            if (!empty($dari) && !empty($sampai)) {
                $query->whereBetween('agenda_kegiatan.tanggal', [$dari, $sampai]);
            }
        }

        $accessibleUnits = $user->getAccessibleUnitCodes();
        $accessibleDepts = $user->getAccessibleDeptCodes();
        $canFilterAll = $user->hasRole('super admin') || $user->can('realkegiatan.laporan') || count($accessibleDepts) > 1 || count($accessibleUnits) > 1;

        // Filters based on role and request
        if ($user->hasRole('karyawan') && !$canFilterAll) {
            $query->where('agenda_kegiatan.id_user', $user->id);
        } else {
            if (!$user->hasRole('super admin')) {
                $query->whereIn('agenda_kegiatan.kode_dept', $accessibleDepts);
                $query->where(function($q) use ($accessibleUnits) {
                    $q->whereIn('agenda_kegiatan.kode_unit', $accessibleUnits)
                      ->orWhereNull('agenda_kegiatan.kode_unit')
                      ->orWhereIn('karyawan.kode_unit', $accessibleUnits);
                });
            }

            if (!empty($request->npp)) {
                $query->where('karyawan.npp', $request->npp);
            }
            if (!empty($request->kode_unit)) {
                $query->where(function($q) use ($request) {
                    $q->where('agenda_kegiatan.kode_unit', $request->kode_unit)
                      ->orWhere('karyawan.kode_unit', $request->kode_unit);
                });
            }
            if (!empty($request->kode_dept)) {
                $query->where('agenda_kegiatan.kode_dept', $request->kode_dept);
            }
            if (!empty($request->kode_jabatan)) {
                $query->where('agenda_kegiatan.kode_jabatan', $request->kode_jabatan);
            }
        }

        $query->orderBy('agenda_kegiatan.tanggal', 'desc');
        $data['agenda_kegiatan'] = $query->get();
        $data['dari'] = $dari;
        $data['sampai'] = $sampai;

        // Resolve departemen for title
        if ($user->hasRole('karyawan') && !$canFilterAll) {
            $data['departemen'] = Departemen::where('kode_dept', $user->kode_dept)->first() ?? (object) ['nama_dept' => ''];
        } else if (!empty($request->kode_dept)) {
            $data['departemen'] = Departemen::where('kode_dept', $request->kode_dept)->first() ?? (object) ['nama_dept' => ''];
        } else {
            $data['departemen'] = (object) ['nama_dept' => 'SEMUA BIDANG'];
        }

        if ($request->export_excel) {
            header("Content-type: application/vnd-ms-excel");
            header("Content-Disposition: attachment; filename=Laporan_Agenda_Kegiatan_" . date('YmdHis') . ".xls");
        }

        return view('agenda_kegiatan.cetak', $data);
    }

    public function getFilterOptions(Request $request)
    {
        $user = User::where('id', auth()->user()->id)->first();
        $accessibleUnits = $user->getAccessibleUnitCodes();
        $accessibleDepts = $user->getAccessibleDeptCodes();

        $kode_unit = $request->kode_unit;
        $kode_dept = $request->kode_dept;
        $kode_jabatan = $request->kode_jabatan;

        $deptsQuery = Departemen::whereIn('kode_dept', function($q) use ($kode_unit) {
            $q->select('kode_dept')->from('karyawan');
            if (!empty($kode_unit)) {
                $q->where('kode_unit', $kode_unit);
            }
        });

        if (!$user->hasRole('super admin')) {
            $deptsQuery->whereIn('kode_dept', $accessibleDepts);
        }
        $departments = $deptsQuery->orderBy('nama_dept')->get();

        $jabsQuery = Jabatan::whereIn('kode_jabatan', function($q) use ($kode_unit, $kode_dept, $user, $accessibleUnits, $accessibleDepts) {
            $q->select('kode_jabatan')->from('karyawan');
            if (!empty($kode_unit)) {
                $q->where('kode_unit', $kode_unit);
            } elseif (!$user->hasRole('super admin')) {
                $q->whereIn('kode_unit', $accessibleUnits);
            }

            if (!empty($kode_dept)) {
                $q->where('kode_dept', $kode_dept);
            } elseif (!$user->hasRole('super admin')) {
                $q->whereIn('kode_dept', $accessibleDepts);
            }
        })->where('kode_jabatan', '!=', 'J00');
        $jabatans = $jabsQuery->orderBy('nama_jabatan')->get();

        $karyQuery = Karyawan::query();
        if (!$user->hasRole('super admin')) {
            $karyQuery->whereIn('kode_unit', $accessibleUnits);
            $karyQuery->whereIn('kode_dept', $accessibleDepts);
        }

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
