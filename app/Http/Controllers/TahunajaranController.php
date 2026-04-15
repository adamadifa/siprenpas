<?php

namespace App\Http\Controllers;

use App\Models\Tahunajaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Redirect;

class TahunajaranController extends Controller
{
    public function index()
    {
        $data['tahun_ajaran'] = Tahunajaran::orderBy('kode_ta', 'desc')->get();
        $data['semester'] = \App\Models\Semester::orderBy('semester', 'asc')->get();
        return view('konfigurasi.tahunajaran.index', $data);
    }

    public function create()
    {
        return view('konfigurasi.tahunajaran.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'tahun_ajaran' => 'required',
            'status' => 'required'
        ]);

        try {
            // Auto-generate kode_ta dari tahun_ajaran
            // Format: 2025/2026 -> TA2526
            $tahun_ajaran = $request->tahun_ajaran;
            $tahun_parts = explode('/', $tahun_ajaran);
            
            if (count($tahun_parts) != 2) {
                return Redirect::back()->with(messageError('Format tahun ajaran tidak valid. Gunakan format: YYYY/YYYY'));
            }
            
            $tahun_awal = substr($tahun_parts[0], -2); // 2 digit terakhir tahun pertama
            $tahun_akhir = substr($tahun_parts[1], -2); // 2 digit terakhir tahun kedua
            $kode_ta = 'TA' . $tahun_awal . $tahun_akhir;
            
            // Validasi unique kode_ta
            $request->merge(['kode_ta' => $kode_ta]);
            $request->validate([
                'kode_ta' => 'required|max:6|min:6|unique:konfigurasi_tahun_ajaran,kode_ta',
            ]);
            
            // Jika status aktif (1), set semua data lain menjadi nonaktif (0)
            if ($request->status == 1) {
                Tahunajaran::where('status', 1)->update(['status' => 0]);
            }
            
            Tahunajaran::create([
                'kode_ta' => $kode_ta,
                'tahun_ajaran' => $request->tahun_ajaran,
                'status' => $request->status
            ]);

            return Redirect::back()->with(messageSuccess('Data Berhasil Disimpan'));
        } catch (\Exception $e) {
            return Redirect::back()->with(messageError($e->getMessage()));
        }
    }

    public function edit($kode_ta)
    {
        $kode_ta = Crypt::decrypt($kode_ta);
        $data['tahunajaran'] = Tahunajaran::where('kode_ta', $kode_ta)->first();
        return view('konfigurasi.tahunajaran.edit', $data);
    }




    public function update(Request $request, $kode_ta)
    {
        $kode_ta = Crypt::decrypt($kode_ta);
        $request->validate([
            'tahun_ajaran' => 'required',
            'status' => 'required'
        ]);

        try {
            // Jika status aktif (1), set semua data lain menjadi nonaktif (0)
            if ($request->status == 1) {
                Tahunajaran::where('status', 1)
                    ->where('kode_ta', '!=', $kode_ta)
                    ->update(['status' => 0]);
            }
            
            Tahunajaran::where('kode_ta', $kode_ta)->update([
                'tahun_ajaran' => $request->tahun_ajaran,
                'status' => $request->status
            ]);

            return Redirect::back()->with(messageSuccess('Data Berhasil Disimpan'));
        } catch (\Exception $e) {
            return Redirect::back()->with(messageError($e->getMessage()));
        }
    }

    public function destroy($kode_ta)
    {
        $kode_ta = Crypt::decrypt($kode_ta);
        try {
            Tahunajaran::where('kode_ta', $kode_ta)->delete();
            return Redirect::back()->with(['success' => 'Data Berhasil Dihapus']);
        } catch (\Exception $e) {
            return Redirect::back()->with(['error' => $e->getMessage()]);
        }
    }

    public function setSemester($id)
    {
        try {
            // Set all to inactive
            \App\Models\Semester::where('status', '1')->update(['status' => '0']);
            // Set selected to active
            \App\Models\Semester::where('id', $id)->update(['status' => '1']);

            return Redirect::back()->with(messageSuccess('Data Berhasil Disimpan'));
        } catch (\Exception $e) {
            return Redirect::back()->with(messageError($e->getMessage()));
        }
    }
}
