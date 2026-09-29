<?php

namespace App\Http\Controllers;

use App\Models\Jenisbiaya;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Redirect;

class JenisbiayaController extends Controller
{
    public function index()
    {
        $data['jenisbiaya'] = Jenisbiaya::orderBy('kode_jenis_biaya')->get();
        return view('datamaster.jenisbiaya.index', $data);
    }

    public function create()
    {
        return view('datamaster.jenisbiaya.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'kode_jenis_biaya' => 'required|max:3|min:3|unique:jenis_biaya,kode_jenis_biaya',
            'jenis_biaya' => 'required',
        ]);

        try {
            Jenisbiaya::create([
                'kode_jenis_biaya' => $request->kode_jenis_biaya,
                'jenis_biaya' => $request->jenis_biaya,
                'tampilkan_di_landing' => $request->has('tampilkan_di_landing') ? 1 : 0,
            ]);

            return Redirect::back()->with(messageSuccess('Data Berhasil Disimpan'));
        } catch (\Exception $e) {
            return Redirect::back()->with(messageError($e->getMessage()));
        }
    }

    public function edit($kode_jenis_biaya)
    {
        $kode_jenis_biaya = Crypt::decrypt($kode_jenis_biaya);
        $data['jenisbiaya'] = Jenisbiaya::where('kode_jenis_biaya', $kode_jenis_biaya)->first();
        return view('datamaster.jenisbiaya.edit', $data);
    }


    public function update(Request $request, $kode_jenis_biaya)
    {
        $kode_jenis_biaya = Crypt::decrypt($kode_jenis_biaya);
        $request->validate([
            'jenis_biaya' => 'required',
        ]);

        try {
            Jenisbiaya::where('kode_jenis_biaya', $kode_jenis_biaya)->update([
                'jenis_biaya' => $request->jenis_biaya,
                'tampilkan_di_landing' => $request->has('tampilkan_di_landing') ? 1 : 0,
            ]);

            return Redirect::back()->with(messageSuccess('Data Berhasil Disimpan'));
        } catch (\Exception $e) {
            return Redirect::back()->with(messageError($e->getMessage()));
        }
    }

    /**
     * Quick toggle tampilkan di landing page via Switch / Checkbox
     */
    public function toggleLanding(Request $request, $kode_jenis_biaya)
    {
        $kode_jenis_biaya = Crypt::decrypt($kode_jenis_biaya);
        $status = $request->input('status', 0);

        try {
            Jenisbiaya::where('kode_jenis_biaya', $kode_jenis_biaya)->update([
                'tampilkan_di_landing' => $status ? 1 : 0,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Status tampilan landing page berhasil diperbarui'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }
    public function destroy($kode_jenis_biaya)
    {
        $kode_jenis_biaya = Crypt::decrypt($kode_jenis_biaya);
        try {
            Jenisbiaya::where('kode_jenis_biaya', $kode_jenis_biaya)->delete();
            return Redirect::back()->with(['success' => 'Data Berhasil Dihapus']);
        } catch (\Exception $e) {
            return Redirect::back()->with(['error' => $e->getMessage()]);
        }
    }
}
