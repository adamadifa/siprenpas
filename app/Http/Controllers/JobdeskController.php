<?php

namespace App\Http\Controllers;

use App\Models\Departemen;
use App\Models\Jabatan;
use App\Models\Jobdesk;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Redirect;
use Jenssegers\Agent\Agent;

class JobdeskController extends Controller
{
    public function index(Request $request)
    {
        $user = User::where('id', auth()->user()->id)->first();
        $query = Jobdesk::query();
        $query->join('departemen', 'jobdesk.kode_dept', '=', 'departemen.kode_dept');
        $query->join('jabatan', 'jobdesk.kode_jabatan', '=', 'jabatan.kode_jabatan');
        $query->orderBy('kode_jobdesk');
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
            
            $query->where('jobdesk.kode_jabatan', $user->kode_jabatan);
            $query->where('jobdesk.kode_dept', $user->kode_dept);
            $data['jobdesk'] = $query->get();
            $data['karyawan'] = $karyawan;
            
            return view('datamaster.jobdesk.index_karyawan', $data);
        }

        if ($user->hasRole(['super admin', 'pimpinan pesantren', 'sekretaris'])) {
            if (!empty($request->kode_jabatan)) {
                $query->where('jobdesk.kode_jabatan', $request->kode_jabatan);
            }
            if (!empty($request->kode_dept)) {
                $query->where('jobdesk.kode_dept', $request->kode_dept);
            }
        } else {
            $query->where('jobdesk.kode_jabatan', $user->kode_jabatan);
            $query->where('jobdesk.kode_dept', $user->kode_dept);
        }

        if (!empty($request->jobdesk_search)) {
            $query->where('jobdesk.jobdesk', 'like', '%' . $request->jobdesk_search . '%');
        }

        $data['jobdesk'] = $query->get();

        $data['jabatan'] = Jabatan::orderBy('kode_jabatan')->where('kode_jabatan', '!=', 'J00')->get();
        $data['departemen'] = Departemen::orderBy('kode_dept')->get();

        $agent = new Agent();
        if ($agent->isMobile()) {
            return view('datamaster.jobdesk.index_mobile', $data);
        }
        return view('datamaster.jobdesk.index', $data);
    }


    public function create()
    {
        $data['jabatan'] = Jabatan::orderBy('kode_jabatan')->where('kode_jabatan', '!=', 'J00')->get();
        $data['departemen'] = Departemen::orderBy('kode_dept')->get();
        $agent = new Agent();
        if ($agent->isMobile()) {
            return view('datamaster.jobdesk.create_mobile', $data);
        }
        return view('datamaster.jobdesk.create', $data);
    }

    public function store(Request $request)
    {
        $user = User::where('id', auth()->user()->id)->first();
        if ($user->hasRole('super admin')) {
            $request->validate([
                'kode_jabatan' => 'required',
                'kode_dept' => 'required',
                'jobdesk' => 'required',
            ]);
            $kode_dept = $request->kode_dept;
            $kode_jabatan = $request->kode_jabatan;
        } else {
            $request->validate([
                'jobdesk' => 'required',
            ]);
            $kode_dept = $user->kode_dept;
            $kode_jabatan = $user->kode_jabatan;
        }


        try {
            $lastjobdesk = Jobdesk::orderBy('kode_jobdesk', 'desc')
                ->where('kode_jabatan', $kode_jabatan)
                ->where('kode_dept', $kode_dept)
                ->first();
            $last_kode_jobdesk = $lastjobdesk != null ? $lastjobdesk->kode_jobdesk : '';
            $kode_jobdesk = buatkode($last_kode_jobdesk, $kode_jabatan . $kode_dept, 4);
            Jobdesk::create([
                'kode_jobdesk' => $kode_jobdesk,
                'jobdesk' => $request->jobdesk,
                'kode_jabatan' => $kode_jabatan,
                'kode_dept' => $kode_dept
            ]);

            $agent = new Agent();

            if ($agent->isMobile()) {
                return redirect(route('jobdesk.index'))->with(messageSuccess('Data Berhasil Disimpan'));
            }
            return Redirect::back()->with(messageSuccess('Data Berhasil Disimpan'));
        } catch (\Exception $e) {
            dd($e->getMessage());
            return Redirect::back()->with(messageError($e->getMessage()));
        }
    }

    public function destroy($kode_jobdesk)
    {

        $kode_jobdesk = Crypt::decrypt($kode_jobdesk);

        try {
            Jobdesk::where('kode_jobdesk', $kode_jobdesk)->delete();
            return Redirect::back()->with(messageSuccess('Data Berhasil Dihapus'));
        } catch (\Exception $e) {
            return Redirect::back()->with(messageError($e->getMessage()));
        }
    }

    public function edit($kode_jobdesk)
    {
        $kode_jobdesk = Crypt::decrypt($kode_jobdesk);
        $data['jobdesk'] = Jobdesk::where('kode_jobdesk', $kode_jobdesk)->first();
        $data['jabatan'] = Jabatan::orderBy('kode_jabatan')->where('kode_jabatan', '!=', 'J00')->get();
        $data['departemen'] = Departemen::orderBy('kode_dept')->get();
        $agent = new Agent();
        if ($agent->isMobile()) {
            return view('datamaster.jobdesk.edit_mobile', $data);
        }
        return view('datamaster.jobdesk.edit', $data);
    }

    public function update(Request $request, $kode_jobdesk)
    {
        $user = User::where('id', auth()->user()->id)->first();
        if ($user->hasRole('super admin')) {
            $request->validate([
                'kode_jabatan' => 'required',
                'kode_dept' => 'required',
                'jobdesk' => 'required',
            ]);
            $kode_dept = $request->kode_dept;
            $kode_jabatan = $request->kode_jabatan;
        } else {
            $request->validate([
                'jobdesk' => 'required',
            ]);
            $kode_dept = $user->kode_dept;
            $kode_jabatan = $user->kode_jabatan;
        }

        $kode_jobdesk = Crypt::decrypt($kode_jobdesk);
        try {
            Jobdesk::where('kode_jobdesk', $kode_jobdesk)->update([
                'kode_jabatan' => $kode_jabatan,
                'kode_dept' => $kode_dept,
                'jobdesk' => $request->jobdesk
            ]);
            $agent = new Agent();

            if ($agent->isMobile()) {
                return redirect(route('jobdesk.index'))->with(messageSuccess('Data Berhasil Diubah'));
            }
            return Redirect::back()->with(messageSuccess('Data Berhasil Diubah'));
        } catch (\Exception $e) {
            return Redirect::back()->with(messageError($e->getMessage()));
        }
    }


    public function getjobdesk(Request $request)
    {
        $user = User::where('id', auth()->user()->id)->first();
        $kode_jabatan = $user->hasRole('super admin') ? $request->kode_jabatan : auth()->user()->kode_jabatan;
        $kode_dept = $user->hasRole('super admin') ? $request->kode_dept : auth()->user()->kode_dept;

        $jobdesk = Jobdesk::where('kode_jabatan', $kode_jabatan)->where('kode_dept', $kode_dept)->get();
        return response()->json($jobdesk);
    }


    public function getjobdesklist(Request $request)
    {
        $user = User::where('id', auth()->user()->id)->first();
        $kode_jabatan = $user->hasRole('super admin') ? $request->kode_jabatan : auth()->user()->kode_jabatan;
        $kode_dept = $user->hasRole('super admin') ? $request->kode_dept : auth()->user()->kode_dept;

        $qjobdesk = Jobdesk::query();
        $qjobdesk->where('kode_jabatan', $kode_jabatan);
        $qjobdesk->where('kode_dept', $kode_dept);
        if (!empty($request->jobdesk_search)) {
            $qjobdesk->where('jobdesk', 'like', '%' . $request->jobdesk_search . '%');
        }
        $jobdesk  = $qjobdesk->get();
        return view('datamaster.jobdesk.getjobdesklist', compact('jobdesk'));
    }
}
