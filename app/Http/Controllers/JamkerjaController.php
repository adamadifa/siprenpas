<?php

namespace App\Http\Controllers;

use App\Models\Jamkerja;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Redirect;

class JamkerjaController extends Controller
{
    public function index(Request $request)
    {
        $query = Jamkerja::query();

        if ($request->filled('nama_jam_kerja')) {
            $search = $request->nama_jam_kerja;
            $query->where('nama_jam_kerja', 'like', "%{$search}%")
                  ->orWhere('kode_jam_kerja', 'like', "%{$search}%");
        }

        $jamkerja = $query->orderBy('kode_jam_kerja')->get();
        return view('konfigurasi.jamkerja.index', compact('jamkerja'));
    }

    public function create()
    {
        return view('konfigurasi.jamkerja.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'kode_jam_kerja' => 'required',
            'nama_jam_kerja' => 'required',
            'jam_masuk' => 'required',
            'jam_pulang' => 'required',
            'total_jam' => 'required|numeric',
            'lintas_hari' => 'required'
        ]);

        try {
            Jamkerja::create([
                'kode_jam_kerja' => $request->kode_jam_kerja,
                'nama_jam_kerja' => $request->nama_jam_kerja,
                'jam_masuk' => $request->jam_masuk,
                'jam_pulang' => $request->jam_pulang,
                'total_jam' => $request->total_jam,
                'lintas_hari' => $request->lintas_hari
            ]);

            return Redirect::back()->with(messageSuccess('Data Berhasil Disimpan'));
        } catch (\Exception $e) {
            return Redirect::back()->with(messageError($e->getMessage()));
        }
    }




    public function edit($kode_jam_kerja)
    {
        $kode_jam_kerja = Crypt::decrypt($kode_jam_kerja);
        $jamkerja = Jamkerja::where('kode_jam_kerja', $kode_jam_kerja)->first();
        return view('konfigurasi.jamkerja.edit', compact('jamkerja'));
    }

    public function update(Request $request, $kode_jam_kerja)
    {
        $kode_jam_kerja = Crypt::decrypt($kode_jam_kerja);
        $request->validate([
            'nama_jam_kerja' => 'required',
            'jam_masuk' => 'required',
            'jam_pulang' => 'required',
            'total_jam' => 'required|numeric',
            'lintas_hari' => 'required'
        ]);

        try {
            Jamkerja::where('kode_jam_kerja', $kode_jam_kerja)->update([
                'nama_jam_kerja' => $request->nama_jam_kerja,
                'jam_masuk' => $request->jam_masuk,
                'jam_pulang' => $request->jam_pulang,
                'total_jam' => $request->total_jam,
                'lintas_hari' => $request->lintas_hari
            ]);

            return Redirect::back()->with(messageSuccess('Data Berhasil Di Update'));
        } catch (\Exception $e) {
            return Redirect::back()->with(messageError($e->getMessage()));
        }
    }


    public function destroy($kode_jam_kerja)
    {
        $kode_jam_kerja = Crypt::decrypt($kode_jam_kerja);
        try {
            Jamkerja::where('kode_jam_kerja', $kode_jam_kerja)->delete();
            return Redirect::back()->with(['success' => 'Data Berhasil Dihapus']);
        } catch (\Exception $e) {
            return Redirect::back()->with(['error' => $e->getMessage()]);
        }
    }
}
