<?php

namespace App\Http\Controllers;

use App\Models\Departemen;
use App\Models\Jabatan;
use App\Models\Programkerja;
use App\Models\ProgramkerjaGroup;
use App\Models\Tahunajaran;
use App\Models\User;
use App\Models\Unit;
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
            'program_kerja_group.kode_dept',
            'program_kerja_group.kode_unit',
            'unit.nama_unit',
            'program_kerja_group.kode_jabatan',
            'jabatan.nama_jabatan',
            DB::raw("GROUP_CONCAT(CONCAT(realisasi_kegiatan.tanggal, ' / ', nama_kegiatan) ORDER BY tanggal SEPARATOR ', ') as realisasi_program")
        );
        $query->join('program_kerja_group', 'program_kerja.kode_program_kerja_group', '=', 'program_kerja_group.kode_program_kerja_group');
        $query->join('departemen', 'program_kerja_group.kode_dept', '=', 'departemen.kode_dept');
        $query->join('jabatan', 'program_kerja_group.kode_jabatan', '=', 'jabatan.kode_jabatan');
        $query->leftJoin('unit', 'program_kerja_group.kode_unit', '=', 'unit.kode_unit');
        $query->join('users', 'program_kerja_group.id_user', '=', 'users.id');
        $query->leftJoin('realisasi_kegiatan', 'program_kerja.kode_program_kerja', '=', 'realisasi_kegiatan.kode_program_kerja');
        if ($user->hasRole(['super admin', 'pimpinan pesantren', 'sekretaris'])) {
            if (!empty($request->kode_jabatan)) {
                $query->where('program_kerja_group.kode_jabatan', $request->kode_jabatan);
            }

            if (!empty($request->kode_dept)) {
                $query->where('program_kerja_group.kode_dept', $request->kode_dept);
            }

            if (!empty($request->kode_unit)) {
                $query->where('program_kerja_group.kode_unit', $request->kode_unit);
            }
        } else {
            // $query->where('program_kerja_group.kode_jabatan', $user->kode_jabatan);
            $query->where('program_kerja_group.kode_dept', $user->kode_dept);
            if (!empty(auth()->user()->kode_unit)) {
                $query->where('program_kerja_group.kode_unit', auth()->user()->kode_unit);
            }
            if (!empty($request->kode_jabatan)) {
                $query->where('program_kerja_group.kode_jabatan', $request->kode_jabatan);
            }
        }

        if (!empty($request->kode_ta)) {
            $query->where('program_kerja_group.kode_ta', $request->kode_ta);
        } elseif ($ta_aktif) {
            $query->where('program_kerja_group.kode_ta', $ta_aktif->kode_ta);
        }

        if (!empty($request->cari)) {
            $query->where('program_kerja.program_kerja', 'like', '%' . $request->programkerja_search . '%');
        }
        $query->groupBy(
            'program_kerja.kode_program_kerja',
            'program_kerja.program_kerja',
            'program_kerja.target_pencapaian',
            'program_kerja.keterangan',
            'program_kerja_group.kode_dept',
            'program_kerja_group.kode_unit',
            'unit.nama_unit',
            'program_kerja_group.kode_jabatan',
            'jabatan.nama_jabatan'
        );
        // $query->orderBy('program_kerja.created_at', 'desc');
        $kode_jabatan = $user->hasRole('super admin') ? $request->kode_jabatan : $user->kode_jabatan;
        $kode_dept = $user->hasRole('super admin') ? $request->kode_dept : $user->kode_dept;
        
        if ($user->hasRole(['super admin', 'pimpinan pesantren', 'sekretaris']) && empty($request->kode_dept)) {
            $data['programkerja'] = collect();
        } else {
            $data['programkerja'] = $query->get();
        }
        
        $activeTa = $request->kode_ta ?: ($ta_aktif ? $ta_aktif->kode_ta : null);

        $data['unit'] = Unit::whereIn('kode_unit', function($q) use ($activeTa) {
            $q->select('kode_unit')->from('program_kerja_group');
            if ($activeTa) {
                $q->where('kode_ta', $activeTa);
            }
        })->where('nama_unit', 'not like', '%undefined%')->orderBy('nama_unit')->get();

        $data['departemen'] = Departemen::whereIn('kode_dept', function($q) use ($activeTa, $request) {
            $q->select('kode_dept')->from('program_kerja_group');
            if ($activeTa) {
                $q->where('kode_ta', $activeTa);
            }
            if (!empty($request->kode_unit)) {
                $q->where('kode_unit', $request->kode_unit);
            }
        })->orderBy('nama_dept')->get();

        $data['jabatan'] = Jabatan::whereIn('kode_jabatan', function($q) use ($activeTa, $request) {
            $q->select('kode_jabatan')->from('program_kerja_group');
            if ($activeTa) {
                $q->where('kode_ta', $activeTa);
            }
            if (!empty($request->kode_unit)) {
                $q->where('kode_unit', $request->kode_unit);
            }
            if (!empty($request->kode_dept)) {
                $q->where('kode_dept', $request->kode_dept);
            }
        })->where('kode_jabatan', '!=', 'J00')->orderBy('nama_jabatan')->get();

        $data['user'] = $user;
        $data['tahunajaran'] = Tahunajaran::all();
        $data['ta_aktif'] = $ta_aktif;

        if ($user->hasRole('karyawan')) {
            $userkaryawan = \App\Models\Userkaryawan::where('id_user', $user->id)->first();
            $karyawan = \App\Models\Karyawan::where('karyawan.npp', $userkaryawan->npp)
                ->join('jabatan', 'karyawan.kode_jabatan', '=', 'jabatan.kode_jabatan')
                ->join('unit', 'karyawan.kode_unit', '=', 'unit.kode_unit')
                ->first();
            
            $dept = \App\Models\Departemen::where('kode_dept', $user->kode_dept)->first();
            if ($karyawan && $dept) {
                $karyawan->nama_dept = $dept->nama_dept;
            }
            
            $data['jabatans'] = Jabatan::whereIn('kode_jabatan', function($q) use ($karyawan, $user) {
                $q->select('kode_jabatan')
                  ->from('karyawan')
                  ->where('kode_unit', $karyawan->kode_unit)
                  ->where('kode_dept', $user->kode_dept);
            })->orderBy('nama_jabatan')->get();
            
            $data['karyawan'] = $karyawan;
            return view('programkerja.index_karyawan', $data);
        }

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
            return view('programkerja.index', $data);
        }
    }

    public function create()
    {
        $data['unit'] = Unit::whereIn('kode_unit', function($q) {
            $q->select('kode_unit')->from('karyawan');
        })->where('nama_unit', 'not like', '%undefined%')->orderBy('nama_unit')->get();

        $data['departemen'] = Departemen::whereIn('kode_dept', function($q) {
            $q->select('kode_dept')->from('karyawan');
        })->orderBy('nama_dept')->get();

        $data['jabatan'] = Jabatan::whereIn('kode_jabatan', function($q) {
            $q->select('kode_jabatan')->from('karyawan');
        })->where('kode_jabatan', '!=', 'J00')->orderBy('nama_jabatan')->get();

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
            $kode_unit = $request->kode_unit;
        } else {
            $request->validate([
                'program_kerja' => 'required',
                'target_pencapaian' => 'required',
                'keterangan' => 'required',
            ]);
            $kode_jabatan = $user->kode_jabatan;
            $kode_dept = $user->kode_dept;
            $kode_unit = $user->kode_unit;
        }

        $ta_aktif = Tahunajaran::where('status', '1')->first();
        if (!$ta_aktif) {
            return Redirect::back()->with(messageError('Tahun ajaran aktif tidak ditemukan.'));
        }
        $ta = explode("/", $ta_aktif->tahun_ajaran);
        $format = substr($ta[0], 2, 2) . substr($ta[1], 2, 2) . $kode_dept;
        try {
            $groupId = substr($ta_aktif->kode_ta . $kode_jabatan . $kode_dept . ($kode_unit ?: 'U00'), 0, 15);
            $group = ProgramkerjaGroup::firstOrCreate(
                ['kode_program_kerja_group' => $groupId],
                [
                    'kode_unit' => $kode_unit,
                    'kode_dept' => $kode_dept,
                    'kode_jabatan' => $kode_jabatan,
                    'kode_ta' => $ta_aktif->kode_ta,
                    'id_user' => auth()->user()->id
                ]
            );

            $lastprogramkerja = Programkerja::where('kode_program_kerja_group', $groupId)
                ->orderBy('kode_program_kerja', 'desc')
                ->first();

            $last_kode_program_kerja = $lastprogramkerja !== null ? $lastprogramkerja->kode_program_kerja : '';
            $kode_program_kerja = buatkode($last_kode_program_kerja, $format, 4);

            Programkerja::create([
                'kode_program_kerja' => $kode_program_kerja,
                'kode_program_kerja_group' => $groupId,
                'program_kerja' => $request->program_kerja,
                'target_pencapaian' => $request->target_pencapaian,
                'keterangan' => $request->keterangan,
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
        $programkerja = Programkerja::where('kode_program_kerja', $kode_program_kerja)->first();
        $data['programkerja'] = $programkerja;

        $data['unit'] = Unit::whereIn('kode_unit', function($q) {
            $q->select('kode_unit')->from('karyawan');
        })->where('nama_unit', 'not like', '%undefined%')->orderBy('nama_unit')->get();

        $data['departemen'] = Departemen::whereIn('kode_dept', function($q) use ($programkerja) {
            $q->select('users.kode_dept')
              ->from('karyawan')
              ->join('user_karyawan', 'karyawan.npp', '=', 'user_karyawan.npp')
              ->join('users', 'user_karyawan.id_user', '=', 'users.id');
            if ($programkerja && $programkerja->group && !empty($programkerja->group->kode_unit)) {
                $q->where('karyawan.kode_unit', $programkerja->group->kode_unit);
            }
        })->orderBy('nama_dept')->get();

        $data['jabatan'] = Jabatan::whereIn('kode_jabatan', function($q) use ($programkerja) {
            $q->select('karyawan.kode_jabatan')->from('karyawan');
            if ($programkerja && $programkerja->group && !empty($programkerja->group->kode_unit)) {
                $q->where('karyawan.kode_unit', $programkerja->group->kode_unit);
            }
            if ($programkerja && $programkerja->group && !empty($programkerja->group->kode_dept)) {
                $q->whereIn('karyawan.npp', function($sub) use ($programkerja) {
                    $sub->select('user_karyawan.npp')
                        ->from('user_karyawan')
                        ->join('users', 'user_karyawan.id_user', '=', 'users.id')
                        ->where('users.kode_dept', $programkerja->group->kode_dept);
                });
            }
        })->where('kode_jabatan', '!=', 'J00')->orderBy('nama_jabatan')->get();

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
            $kode_unit = $request->kode_unit;
        } else {
            $request->validate([
                'program_kerja' => 'required',
                'target_pencapaian' => 'required',
                'keterangan' => 'required',
            ]);
            $kode_jabatan = $user->kode_jabatan;
            $kode_dept = $user->kode_dept;
            $kode_unit = $user->kode_unit;
        }

        try {
            $pk = Programkerja::where('kode_program_kerja', $kode_jam_kerja)->first();
            $groupId = substr($pk->group->kode_ta . $kode_jabatan . $kode_dept . ($kode_unit ?: 'U00'), 0, 15);

            $group = ProgramkerjaGroup::firstOrCreate(
                ['kode_program_kerja_group' => $groupId],
                [
                    'kode_unit' => $kode_unit,
                    'kode_dept' => $kode_dept,
                    'kode_jabatan' => $kode_jabatan,
                    'kode_ta' => $pk->group->kode_ta,
                    'id_user' => auth()->user()->id
                ]
            );

            $pk->update([
                'kode_program_kerja_group' => $groupId,
                'program_kerja' => $request->program_kerja,
                'target_pencapaian' => $request->target_pencapaian,
                'keterangan' => $request->keterangan,
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
        $qprogramkerja = Programkerja::query()
            ->join('program_kerja_group', 'program_kerja.kode_program_kerja_group', '=', 'program_kerja_group.kode_program_kerja_group')
            ->where('program_kerja_group.kode_dept', $kode_dept);
        if (!empty($request->kode_unit)) {
            $qprogramkerja->where('program_kerja_group.kode_unit', $request->kode_unit);
        }
        $qprogramkerja->where('program_kerja_group.kode_ta', $ta_aktif->kode_ta);
        $program_kerja = $qprogramkerja->get();
        return response()->json($program_kerja);
    }

    public function getprogramkerjalist(Request $request)
    {
        $user = User::where('id', auth()->user()->id)->first();
        $kode_jabatan = $user->hasRole('super admin') ? $request->kode_jabatan : auth()->user()->kode_jabatan;
        $kode_dept = $user->hasRole('super admin') ? $request->kode_dept : auth()->user()->kode_dept;

        $qprogramkerja = Programkerja::query()
            ->join('program_kerja_group', 'program_kerja.kode_program_kerja_group', '=', 'program_kerja_group.kode_program_kerja_group')
            ->where('program_kerja_group.kode_dept', $kode_dept);
        if (!empty($request->kode_unit)) {
            $qprogramkerja->where('program_kerja_group.kode_unit', $request->kode_unit);
        }
        if (!empty($request->cari)) {
            $qprogramkerja->where('program_kerja.program_kerja', 'like', '%' . $request->cari . '%');
        }
        $qprogramkerja->where('program_kerja_group.kode_ta', $request->kode_ta);
        $program_kerja = $qprogramkerja->get();

        return view('programkerja.getprogramkerjalist', compact('program_kerja'));
    }

    public function reset()
    {
        $user = User::where('id', auth()->user()->id)->first();
        if (!$user->hasRole('super admin')) {
            abort(403, 'Unauthorized action.');
        }

        try {
            DB::statement('SET FOREIGN_KEY_CHECKS=0;');
            DB::table('program_kerja')->delete();
            DB::table('program_kerja_group')->delete();
            DB::statement('SET FOREIGN_KEY_CHECKS=1;');
            return Redirect::back()->with(messageSuccess('Semua data program kerja berhasil direset'));
        } catch (\Exception $e) {
            DB::statement('SET FOREIGN_KEY_CHECKS=1;');
            return Redirect::back()->with(messageError($e->getMessage()));
        }
    }

    public function getFilterOptions(Request $request)
    {
        $kode_unit = $request->kode_unit;
        $kode_dept = $request->kode_dept;
        $kode_ta = $request->kode_ta;

        $ta_aktif = Tahunajaran::where('status', 1)->first();
        $activeTa = $kode_ta ?: ($ta_aktif ? $ta_aktif->kode_ta : null);

        $deptsQuery = ProgramkerjaGroup::query()
            ->join('departemen', 'program_kerja_group.kode_dept', '=', 'departemen.kode_dept')
            ->select('program_kerja_group.kode_dept', 'departemen.nama_dept')
            ->distinct();
        if (!empty($kode_unit)) {
            $deptsQuery->where('program_kerja_group.kode_unit', $kode_unit);
        }
        if ($activeTa) {
            $deptsQuery->where('program_kerja_group.kode_ta', $activeTa);
        }
        $departments = $deptsQuery->orderBy('departemen.nama_dept')->get();

        $jabsQuery = ProgramkerjaGroup::query()
            ->join('jabatan', 'program_kerja_group.kode_jabatan', '=', 'jabatan.kode_jabatan')
            ->select('program_kerja_group.kode_jabatan', 'jabatan.nama_jabatan')
            ->distinct();
        if (!empty($kode_unit)) {
            $jabsQuery->where('program_kerja_group.kode_unit', $kode_unit);
        }
        if (!empty($kode_dept)) {
            $jabsQuery->where('program_kerja_group.kode_dept', $kode_dept);
        }
        if ($activeTa) {
            $jabsQuery->where('program_kerja_group.kode_ta', $activeTa);
        }
        $jabatans = $jabsQuery->orderBy('jabatan.nama_jabatan')->get();

        return response()->json([
            'departments' => $departments,
            'jabatans' => $jabatans
        ]);
    }

    public function getKaryawanFilterOptions(Request $request)
    {
        $kode_unit = $request->kode_unit;
        $kode_dept = $request->kode_dept;

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

        return response()->json([
            'departments' => $departments,
            'jabatans' => $jabatans
        ]);
    }
}
