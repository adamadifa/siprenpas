<?php

namespace App\Http\Controllers;

use App\Models\Departemen;
use App\Models\Karyawan;
use App\Models\Realisasikegiatan;
use App\Models\User;
use App\Models\Userkaryawan;
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
            $data['karyawan'] = Karyawan::orderBy('nama_lengkap', 'asc')->get();
            $data['departemen'] = Departemen::orderBy('nama_dept', 'asc')->get();
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
            if (!empty($request->kode_dept)) {
                $query->where('realisasi_kegiatan.kode_dept', $request->kode_dept);
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
}
