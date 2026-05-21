<?php

namespace App\Http\Controllers;

use App\Models\Departemen;
use App\Models\Jabatan;
use App\Models\Programkerja;
use App\Models\Tahunajaran;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Jenssegers\Agent\Agent;

class ProgramkerjaController extends Controller
{
    public function index(Request $request)
    {
        $user = User::where('id', auth()->user()->id)->first();
        $ta_aktif = Tahunajaran::where('status', 1)->first();
        $query = Programkerja::query();
        $query->select(
            'program_kerja.kode_program_kerja',
            'program_kerja.program_kerja',
            'program_kerja.target_pencapaian',
            'program_kerja.keterangan',
            'program_kerja.kode_dept',
            DB::raw("GROUP_CONCAT(CONCAT(realisasi_kegiatan.tanggal, ' / ', nama_kegiatan) ORDER BY tanggal SEPARATOR ', ') as realisasi_program")
        );
        $query->join('departemen', 'program_kerja.kode_dept', '=', 'departemen.kode_dept');
        $query->join('jabatan', 'program_kerja.kode_jabatan', '=', 'jabatan.kode_jabatan');
        $query->join('users', 'program_kerja.id_user', '=', 'users.id');
        $query->leftJoin('realisasi_kegiatan', 'program_kerja.kode_program_kerja', '=', 'realisasi_kegiatan.kode_program_kerja');
        if ($user->hasRole(['super admin', 'pimpinan pesantren', 'sekretaris'])) {
            if (!empty($request->kode_jabatan)) {
                $query->where('program_kerja.kode_jabatan', $request->kode_jabatan);
            }

            if (!empty($request->kode_dept)) {
                $query->where('program_kerja.kode_dept', $request->kode_dept);
            }
        } else {
            // $query->where('program_kerja.kode_jabatan', $user->kode_jabatan);
            $query->where('program_kerja.kode_dept', $user->kode_dept);
        }

        if (!empty($request->kode_ta)) {
            $query->where('program_kerja.kode_ta', $request->kode_ta);
        } elseif ($ta_aktif) {
            $query->where('program_kerja.kode_ta', $ta_aktif->kode_ta);
        }

        if (!empty($request->cari)) {
            $query->where('program_kerja.program_kerja', 'like', '%' . $request->programkerja_search . '%');
        }
        $query->groupBy(
            'program_kerja.kode_program_kerja',
            'program_kerja.program_kerja',
            'program_kerja.target_pencapaian',
            'program_kerja.keterangan',
            'program_kerja.kode_dept'
        );
        // $query->orderBy('program_kerja.created_at', 'desc');
        $kode_jabatan = $user->hasRole('super admin') ? $request->kode_jabatan : $user->kode_jabatan;
        $kode_dept = $user->hasRole('super admin') ? $request->kode_dept : $user->kode_dept;
        $data['programkerja'] = $query->get();
        $data['user'] = $user;
        $data['tahunajaran'] = Tahunajaran::all();
        $data['ta_aktif'] = $ta_aktif;

        $agent = new Agent();
        if ($agent->isMobile()) {
            return view('programkerja.index_mobile', $data);
        }
        if ($request->cetak == 1) {
            if (empty($kode_dept)) {
                return Redirect::back()->with(messageError('Pilih Departemen terlebih dahulu'));
            }
            $data['jabatan'] = Jabatan::orderBy('kode_jabatan')->where('kode_jabatan', $kode_jabatan)->first();
            $data['departemen'] = Departemen::orderBy('kode_dept')->where('kode_dept', $kode_dept)->first();
            return view('programkerja.cetak', $data);
        } else {
            $data['jabatan'] = Jabatan::orderBy('kode_jabatan')->where('kode_jabatan', '!=', 'J00')->get();
            $data['departemen'] = Departemen::orderBy('kode_dept')->get();
            return view('programkerja.index', $data);
        }
    }

    public function create()
    {
        $data['jabatan'] = Jabatan::orderBy('kode_jabatan')->where('kode_jabatan', '!=', 'J00')->get();
        $data['departemen'] = Departemen::orderBy('kode_dept')->get();
        $data['user'] = User::where('id', auth()->user()->id)->first();
        $agent = new Agent();
        if ($agent->isMobile()) {
            return view('programkerja.create_mobile', $data);
        }
        return view('programkerja.create', $data);
    }

    public function store(Request $request)
    {

        $user = User::where('id', auth()->user()->id)->first();
        if ($user->hasRole('super admin')) {
            $request->validate([

                'program_kerja' => 'required',
                'target_pencapaian' => 'required',
                'keterangan' => 'required',
                'kode_jabatan' => 'required',
                'kode_dept' => 'required',
            ]);

            $kode_jabatan = $request->kode_jabatan;
            $kode_dept = $request->kode_dept;
        } else {
            $request->validate([

                'program_kerja' => 'required',
                'target_pencapaian' => 'required',
                'keterangan' => 'required',
            ]);
            $kode_jabatan = $user->kode_jabatan;
            $kode_dept = $user->kode_dept;
        }


        $ta_aktif = Tahunajaran::where('status', '1')->first();
        if (!$ta_aktif) {
            return Redirect::back()->with(messageError('Tahun ajaran aktif tidak ditemukan.'));
        }
        $ta = explode("/", $ta_aktif->tahun_ajaran);
        $format = substr($ta[0], 2, 2) . substr($ta[1], 2, 2) . $kode_dept;
        try {
            $lastprogramkerja = Programkerja::where('kode_dept', $kode_dept)
                ->where('kode_ta', $ta_aktif->kode_ta)
                ->orderBy('kode_program_kerja', 'desc')
                ->first();

            // dd($lastprogramkerja);
            $last_kode_program_kerja = $lastprogramkerja !== null ? $lastprogramkerja->kode_program_kerja : '';
            $kode_program_kerja = buatkode($last_kode_program_kerja, $format, 4);
            // dd($kode_program_kerja);
            Programkerja::create([
                'kode_program_kerja' => $kode_program_kerja,
                'program_kerja' => $request->program_kerja,
                'target_pencapaian' => $request->target_pencapaian,
                'keterangan' => $request->keterangan,
                'kode_dept' => $kode_dept,
                'kode_jabatan' => $kode_jabatan,
                'kode_ta' => $ta_aktif->kode_ta,
                'id_user' => auth()->user()->id
            ]);

            $agent = new Agent();

            if ($agent->isMobile()) {
                return redirect(route('programkerja.index'))->with(messageSuccess('Data Berhasil Disimpan'));
            }

            return Redirect::back()->with(messageSuccess('Data Berhasil Disimpan'));
        } catch (\Exception $e) {
            return Redirect::back()->with(messageError($e->getMessage()));
        }
    }


    public function edit($kode_program_kerja)
    {
        $kode_program_kerja = Crypt::decrypt($kode_program_kerja);
        $data['jabatan'] = Jabatan::orderBy('kode_jabatan')->where('kode_jabatan', '!=', 'J00')->get();
        $data['departemen'] = Departemen::orderBy('kode_dept')->get();
        $data['programkerja'] = Programkerja::where('kode_program_kerja', $kode_program_kerja)->first();
        $data['user'] = User::where('id', auth()->user()->id)->first();
        $agent = new Agent();
        if ($agent->isMobile()) {
            return view('programkerja.edit_mobile', $data);
        }
        return view('programkerja.edit', $data);
    }


    public function update(Request $request, $kode_jam_kerja)
    {
        $kode_jam_kerja = Crypt::decrypt($kode_jam_kerja);
        $user = User::where('id', auth()->user()->id)->first();
        if ($user->hasRole('super admin')) {
            $request->validate([

                'program_kerja' => 'required',
                'target_pencapaian' => 'required',

                'keterangan' => 'required',
                'kode_jabatan' => 'required',
                'kode_dept' => 'required',
            ]);

            $kode_jabatan = $request->kode_jabatan;
            $kode_dept = $request->kode_dept;
        } else {
            $request->validate([

                'program_kerja' => 'required',
                'target_pencapaian' => 'required',

                'keterangan' => 'required',
            ]);
            $kode_jabatan = $user->kode_jabatan;
            $kode_dept = $user->kode_dept;
        }



        try {

            Programkerja::where('kode_program_kerja', $kode_jam_kerja)->update([
                'program_kerja' => $request->program_kerja,
                'target_pencapaian' => $request->target_pencapaian,
                'keterangan' => $request->keterangan,
                'kode_dept' => $kode_dept,
                'kode_jabatan' => $kode_jabatan,
            ]);
            $agent = new Agent();

            if ($agent->isMobile()) {
                return redirect(route('programkerja.index'))->with(messageSuccess('Data Berhasil Disimpan'));
            }
            return Redirect::back()->with(messageSuccess('Data Berhasil Disimpan'));
        } catch (\Exception $e) {
            return Redirect::back()->with(messageError($e->getMessage()));
        }
    }

    public function destroy($kode_program_kerja)
    {
        $kode_program_kerja = Crypt::decrypt($kode_program_kerja);
        try {
            Programkerja::where('kode_program_kerja', $kode_program_kerja)->delete();
            return Redirect::back()->with('success', 'Data Berhasil Dihapus');
        } catch (\Exception $e) {
            return Redirect::back()->with('error', $e->getMessage());
        }
    }


    public function getprogramkerja(Request $request)
    {
        $user = User::where('id', auth()->user()->id)->first();
        $kode_jabatan = $user->hasRole('super admin') ? $request->kode_jabatan : auth()->user()->kode_jabatan;
        $kode_dept = $user->hasRole('super admin') ? $request->kode_dept : auth()->user()->kode_dept;
        $ta_aktif = Tahunajaran::where('status', 1)->first();
        if (!$ta_aktif) {
            return response()->json([]);
        }
        $qprogramkerja = Programkerja::query();
        // $qprogramkerja->where('program_kerja.kode_jabatan', $kode_jabatan);
        $qprogramkerja->where('program_kerja.kode_dept', $kode_dept);
        // if (!empty($request->cari)) {
        //     $qprogramkerja->where('program_kerja.program_kerja', 'like', '%' . $request->cari . '%');
        // }
        $qprogramkerja->where('program_kerja.kode_ta', $ta_aktif->kode_ta);
        $program_kerja = $qprogramkerja->get();
        return response()->json($program_kerja);
    }

    public function getprogramkerjalist(Request $request)
    {
        $user = User::where('id', auth()->user()->id)->first();
        $kode_jabatan = $user->hasRole('super admin') ? $request->kode_jabatan : auth()->user()->kode_jabatan;
        $kode_dept = $user->hasRole('super admin') ? $request->kode_dept : auth()->user()->kode_dept;

        $qprogramkerja = Programkerja::query();
        // $qprogramkerja->where('program_kerja.kode_jabatan', $kode_jabatan);
        $qprogramkerja->where('program_kerja.kode_dept', $kode_dept);
        if (!empty($request->cari)) {
            $qprogramkerja->where('program_kerja.program_kerja', 'like', '%' . $request->cari . '%');
        }
        $qprogramkerja->where('program_kerja.kode_ta', $request->kode_ta);
        $program_kerja = $qprogramkerja->get();


        return view('programkerja.getprogramkerjalist', compact('program_kerja'));
    }
}
