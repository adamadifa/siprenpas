<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Agendakegiatan;
use App\Models\Jabatan;
use App\Models\Departemen;
use App\Models\Jobdesk;
use App\Models\User;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Redirect;
use Jenssegers\Agent\Agent;
use Barryvdh\DomPDF\Facade\Pdf;

class AgendakegiatanController extends Controller
{
    public function index(Request $request)
    {
        $user = User::where('id', auth()->user()->id)->first();
        $query = Agendakegiatan::query();
        $query->select('agenda_kegiatan.*', 'name');
        $query->join('departemen', 'agenda_kegiatan.kode_dept', '=', 'departemen.kode_dept');
        $query->join('jabatan', 'agenda_kegiatan.kode_jabatan', '=', 'jabatan.kode_jabatan');
        $query->join('users', 'agenda_kegiatan.id_user', '=', 'users.id');
        if ($user->hasRole('karyawan')) {
            $userkaryawan = \App\Models\Userkaryawan::where('id_user', $user->id)->first();
            $karyawan = \App\Models\Karyawan::where('karyawan.npp', $userkaryawan->npp)
                ->join('jabatan', 'karyawan.kode_jabatan', '=', 'jabatan.kode_jabatan')
                ->join('unit', 'karyawan.kode_unit', '=', 'unit.kode_unit')
                ->first();
            
            $dept = Departemen::where('kode_dept', $user->kode_dept)->first();
            if ($karyawan && $dept) {
                $karyawan->nama_dept = $dept->nama_dept;
            }
            
            $data['karyawan'] = $karyawan;
            
            // Only show employee's own agenda kegiatan
            $query->where('agenda_kegiatan.id_user', $user->id);
            if (!empty($request->dari) && !empty($request->sampai)) {
                $query->whereBetween('tanggal', [$request->dari, $request->sampai]);
            }
            
            $query->orderBy('tanggal', 'desc');
            
            // Handle printing for Karyawan Agenda
            if ($request->cetak || $request->cetak_pdf) {
                $data['agenda_kegiatan'] = $query->get();
                $data['jabatan'] = Jabatan::where('kode_jabatan', $user->kode_jabatan)->first();
                $data['departemen'] = Departemen::where('kode_dept', $user->kode_dept)->first();
                $data['dari'] = $request->dari;
                $data['sampai'] = $request->sampai;
                
                if ($request->cetak_pdf) {
                    $pdf = Pdf::loadView('agenda_kegiatan.cetakpdf', $data)->setPaper('a4', 'landscape');
                    return $pdf->stream('agenda_kegiatan_' . $request->dari . '_' . $request->sampai . '_' . $user->kode_dept . '.pdf');
                }
                return view('agenda_kegiatan.cetak', $data);
            }
            
            $data['agenda_kegiatan'] = $query->paginate(30)->appends($request->all());
            $data['user'] = $user;
            
            return view('agenda_kegiatan.index_karyawan', $data);
        }

        if ($user->hasRole('super admin')) {
            if (!empty($request->kode_jabatan)) {
                $query->where('agenda_kegiatan.kode_jabatan', $request->kode_jabatan);
            }
            if (!empty($request->kode_dept)) {
                $query->where('agenda_kegiatan.kode_dept', $request->kode_dept);
            }
        } else {
            $query->where('agenda_kegiatan.kode_jabatan', $user->kode_jabatan);
            $query->where('agenda_kegiatan.kode_dept', $user->kode_dept);
        }



        $data['user'] = $user;
        $data['jabatan'] = Jabatan::orderBy('kode_jabatan')->where('kode_jabatan', '!=', 'J00')->get();
        $data['departemen'] = Departemen::orderBy('kode_dept')->get();

        $agent = new Agent();
        if ($agent->isMobile()) {
            $query->orderBy('tanggal', 'desc');
            $data['agenda_kegiatan'] = $query->get();
            return view('agenda_kegiatan.index_mobile', $data);
        }

        if ($request->cetak || $request->cetak_pdf) {
            $query->orderBy('tanggal');
            $data['agenda_kegiatan'] = $query->get();
            $kode_jabatan = $user->hasRole('super admin') ? $request->kode_jabatan : $user->kode_jabatan;
            $kode_dept = $user->hasRole('super admin') ? $request->kode_dept : $user->kode_dept;
            $data['jabatan'] = Jabatan::orderBy('kode_jabatan')->where('kode_jabatan', $kode_jabatan)->first();
            $data['departemen'] = Departemen::orderBy('kode_dept')->where('kode_dept', $kode_dept)->first();
            $data['dari'] = $request->dari;
            $data['sampai'] = $request->sampai;
            if ($request->cetak_pdf) {
                $pdf = Pdf::loadView('agenda_kegiatan.cetakpdf', $data)->setPaper('a4', 'landscape');
                return $pdf->stream('agenda_kegiatan_' . $request->dari . '_' . $request->sampai . '_' . $kode_dept . '_' . $kode_jabatan . '.pdf');
            }
            return view('agenda_kegiatan.cetak', $data);
        }
        $query->orderBy('tanggal', 'desc');
        $data['agenda_kegiatan'] = $query->paginate(30);
        return view('agenda_kegiatan.index', $data);
    }


    public function create()
    {
        $user = User::where('id', auth()->user()->id)->first();
        $data['user'] = $user;
        $data['jabatan'] = Jabatan::orderBy('kode_jabatan')->where('kode_jabatan', '!=', 'J00')->get();
        $data['departemen'] = Departemen::orderBy('kode_dept')->get();
        $agent = new Agent();
        if ($agent->isMobile()) {
            return view('agenda_kegiatan.create_mobile', $data);
        }
        return view('agenda_kegiatan.create', $data);
    }

    public function store(Request $request)
    {
        $user = User::where('id', auth()->user()->id)->first();
        if ($user->hasRole('super admin')) {
            $request->validate([
                'tanggal' => 'required',
                'nama_kegiatan' => 'required',
                'kode_jabatan' => 'required',
                'kode_dept' => 'required',
                'uraian_kegiatan' => 'required',
            ]);

            $kode_jabatan = $request->kode_jabatan;
            $kode_dept = $request->kode_dept;
        } else {
            $request->validate([
                'tanggal' => 'required',
                'nama_kegiatan' => 'required',
                'uraian_kegiatan' => 'required',
            ]);
            $kode_jabatan = $user->kode_jabatan;
            $kode_dept = $user->kode_dept;
        }


        try {
            AgendaKegiatan::create([
                'tanggal' => $request->tanggal,
                'nama_kegiatan' => $request->nama_kegiatan,
                'kode_jabatan' => $kode_jabatan,
                'kode_dept' => $kode_dept,
                'uraian_kegiatan' => $request->uraian_kegiatan,
                'id_user' => auth()->user()->id
            ]);

            $agent = new Agent();
            if ($agent->isMobile()) {
                return redirect()->route('agendakegiatan.index')->with(messageSuccess('Data Berhasil Disimpan'));
            }
            return Redirect::back()->with(messageSuccess('Data Berhasil Disimpan'));
        } catch (\Exception $e) {
            return Redirect::back()->with(messageError($e->getMessage()));
        }
    }

    public function destroy($id)
    {
        $id = Crypt::decrypt($id);

        try {
            AgendaKegiatan::where('id', $id)->delete();
            return Redirect::back()->with('success', 'Data Berhasil Dihapus');
        } catch (\Exception $e) {
            return Redirect::back()->with('error', $e->getMessage());
        }
    }

    public function edit($id)
    {
        $id = Crypt::decrypt($id);
        $data['user'] = User::where('id', auth()->user()->id)->first();
        $data['jabatan'] = Jabatan::orderBy('kode_jabatan')->where('kode_jabatan', '!=', 'J00')->get();
        $data['departemen'] = Departemen::orderBy('kode_dept')->get();
        $data['agenda_kegiatan'] = AgendaKegiatan::where('id', $id)->first();
        $agent = new Agent();
        if ($agent->isMobile()) {
            return view('agenda_kegiatan.edit_mobile', $data);
        }
        return view('agenda_kegiatan.edit', $data);
    }

    public function update(Request $request, $id)
    {
        $id = Crypt::decrypt($id);
        $user = User::where('id', auth()->user()->id)->first();
        if ($user->hasRole('super admin')) {
            $request->validate([
                'tanggal' => 'required',
                'nama_kegiatan' => 'required',
                'kode_jabatan' => 'required',
                'kode_dept' => 'required',
                'uraian_kegiatan' => 'required',
                'file' => 'mimes:jpg,jpeg,png|max:1024',
            ]);
            $kode_jabatan = $request->kode_jabatan;
            $kode_dept = $request->kode_dept;
        } else {
            $request->validate([
                'tanggal' => 'required',
                'nama_kegiatan' => 'required',
                'uraian_kegiatan' => 'required',
                'file' => 'mimes:jpg,jpeg,png|max:1024',
            ]);
            $kode_jabatan = auth()->user()->kode_jabatan;
            $kode_dept = auth()->user()->kode_dept;
        }


        try {
            $agenda_kegiatan = AgendaKegiatan::find($id);
            $agenda_kegiatan->update([
                'tanggal' => $request->tanggal,
                'nama_kegiatan' => $request->nama_kegiatan,
                'kode_jabatan' => $kode_jabatan,
                'kode_dept' => $kode_dept,
                'uraian_kegiatan' => $request->uraian_kegiatan,
                'id_user' => auth()->user()->id
            ]);
            $agent = new Agent();
            if ($agent->isMobile()) {
                return redirect()->route('agendakegiatan.index')->with('success', 'Data Berhasil Diupdate');
            }
            return Redirect::back()->with('success', 'Data Berhasil Diupdate');
        } catch (\Exception $e) {
            return Redirect::back()->with('error', $e->getMessage());
        }
    }


    public function getagendakegiatan(Request $request)
    {
        $user = User::where('id', auth()->user()->id)->first();
        $tanggal = $request->tanggal;
        $query = Agendakegiatan::query();
        $query->select('agenda_kegiatan.*', 'name');
        $query->join('departemen', 'agenda_kegiatan.kode_dept', '=', 'departemen.kode_dept');
        $query->join('jabatan', 'agenda_kegiatan.kode_jabatan', '=', 'jabatan.kode_jabatan');
        $query->join('users', 'agenda_kegiatan.id_user', '=', 'users.id');
        $query->where('agenda_kegiatan.kode_jabatan', $user->kode_jabatan);
        $query->where('agenda_kegiatan.kode_dept', $user->kode_dept);
        $query->where('agenda_kegiatan.tanggal', $tanggal);
        $query->where('agenda_kegiatan.id_user', auth()->user()->id);
        $query->orderBy('tanggal');
        $data['agendakegiatan'] = $query->get();
        return view('agenda_kegiatan.getagendakegiatan', $data);
    }

    public function show($id)
    {
        $id = Crypt::decrypt($id);
        $data['agenda'] = AgendaKegiatan::where('id', $id)->first();
        return view('agenda_kegiatan.show', $data);
    }
}
