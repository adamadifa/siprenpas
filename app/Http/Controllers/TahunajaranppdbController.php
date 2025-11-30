<?php

namespace App\Http\Controllers;

use App\Models\Tahunajaranppdb;
use App\Models\Tahunajaranppdbppdb;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Redirect;

class TahunajaranppdbController extends Controller
{
    public function index()
    {
        $data['tahun_ajaran'] = Tahunajaranppdb::orderBy('kode_ta', 'desc')->get();
        return view('konfigurasi.tahunajaranppdb.index', $data);
    }

    public function create()
    {
        return view('konfigurasi.tahunajaranppdb.create');
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
                'kode_ta' => 'required|max:6|min:6|unique:konfigurasi_tahunajaran_ppdb,kode_ta',
            ]);
            
            // Jika status aktif (1), set semua data lain menjadi nonaktif (0)
            if ($request->status == 1) {
                Tahunajaranppdb::where('status', 1)->update(['status' => 0]);
            }
            
            Tahunajaranppdb::create([
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
        $data['tahunajaran'] = Tahunajaranppdb::where('kode_ta', $kode_ta)->first();
        return view('konfigurasi.tahunajaranppdb.edit', $data);
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
                Tahunajaranppdb::where('status', 1)
                    ->where('kode_ta', '!=', $kode_ta)
                    ->update(['status' => 0]);
            }
            
            Tahunajaranppdb::where('kode_ta', $kode_ta)->update([
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
            Tahunajaranppdb::where('kode_ta', $kode_ta)->delete();
            return Redirect::back()->with(['success' => 'Data Berhasil Dihapus']);
        } catch (\Exception $e) {
            return Redirect::back()->with(['error' => $e->getMessage()]);
        }
    }
}
