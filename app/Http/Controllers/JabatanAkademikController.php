<?php

namespace App\Http\Controllers;

use App\Models\JabatanAkademik;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Redirect;

class JabatanAkademikController extends Controller
{
    public function index(Request $request)
    {
        $query = JabatanAkademik::query();
        if ($request->has('nama_jabatan_search')) {
            $query->where('nama_jabatan', 'like', '%' . $request->nama_jabatan_search . '%');
        }
        $jabatan_akademik = $query->orderBy('urutan')->get();
        return view('akademik.jabatan_akademik.index', compact('jabatan_akademik'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'kode_jabatan' => 'required|unique:jabatan_akademik,kode_jabatan',
            'nama_jabatan' => 'required',
            'urutan' => 'required|integer'
        ]);

        try {
            JabatanAkademik::create([
                'kode_jabatan' => $request->kode_jabatan,
                'nama_jabatan' => $request->nama_jabatan,
                'urutan' => $request->urutan,
                'tampil_di_raport' => $request->has('tampil_di_raport') ? 1 : 0
            ]);
            return Redirect::back()->with(['success' => 'Data Berhasil Disimpan']);
        } catch (\Exception $e) {
            return Redirect::back()->with(['warning' => 'Data Gagal Disimpan: ' . $e->getMessage()]);
        }
    }

    public function edit($kode_jabatan)
    {
        $kode_jabatan = Crypt::decrypt($kode_jabatan);
        $jabatan_akademik = JabatanAkademik::where('kode_jabatan', $kode_jabatan)->first();
        return view('akademik.jabatan_akademik.edit', compact('jabatan_akademik'));
    }

    public function update(Request $request, $kode_jabatan)
    {
        $kode_jabatan = Crypt::decrypt($kode_jabatan);
        $request->validate([
            'nama_jabatan' => 'required',
            'urutan' => 'required|integer'
        ]);

        try {
            JabatanAkademik::where('kode_jabatan', $kode_jabatan)->update([
                'nama_jabatan' => $request->nama_jabatan,
                'urutan' => $request->urutan,
                'tampil_di_raport' => $request->has('tampil_di_raport') ? 1 : 0
            ]);
            return Redirect::back()->with(['success' => 'Data Berhasil Diupdate']);
        } catch (\Exception $e) {
            return Redirect::back()->with(['warning' => 'Data Gagal Diupdate: ' . $e->getMessage()]);
        }
    }

    public function destroy($kode_jabatan)
    {
        $kode_jabatan = Crypt::decrypt($kode_jabatan);
        try {
            JabatanAkademik::where('kode_jabatan', $kode_jabatan)->delete();
            return Redirect::back()->with(['success' => 'Data Berhasil Dihapus']);
        } catch (\Exception $e) {
            return Redirect::back()->with(['warning' => 'Data Gagal Dihapus: ' . $e->getMessage()]);
        }
    }
}
