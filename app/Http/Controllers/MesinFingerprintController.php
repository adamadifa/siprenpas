<?php

namespace App\Http\Controllers;

use App\Models\MesinFingerprint;
use App\Models\LogMesinPresensi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Redirect;

class MesinFingerprintController extends Controller
{
    public function index(Request $request)
    {
        $mesin = MesinFingerprint::orderBy('id')->get();
        return view('konfigurasi.mesinfingerprint.index', compact('mesin'));
    }

    public function create()
    {
        return view('konfigurasi.mesinfingerprint.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_mesin' => 'required',
            'sn' => 'required|unique:mesin_fingerprint,sn',
            'titik_koordinat' => 'nullable',
            'status' => 'required|in:Aktif,Nonaktif',
        ]);

        try {
            MesinFingerprint::create([
                'nama_mesin' => $request->nama_mesin,
                'sn' => $request->sn,
                'titik_koordinat' => $request->titik_koordinat,
                'status' => $request->status,
            ]);

            return Redirect::back()->with(messageSuccess('Data Mesin Fingerprint Berhasil Disimpan'));
        } catch (\Exception $e) {
            return Redirect::back()->with(messageError($e->getMessage()));
        }
    }

    public function edit($id)
    {
        $id = Crypt::decrypt($id);
        $mesin = MesinFingerprint::find($id);
        return view('konfigurasi.mesinfingerprint.edit', compact('mesin'));
    }

    public function update(Request $request, $id)
    {
        $id = Crypt::decrypt($id);
        $request->validate([
            'nama_mesin' => 'required',
            'sn' => 'required|unique:mesin_fingerprint,sn,' . $id,
            'status' => 'required|in:Aktif,Nonaktif',
        ]);

        try {
            MesinFingerprint::where('id', $id)->update([
                'nama_mesin' => $request->nama_mesin,
                'sn' => $request->sn,
                'titik_koordinat' => $request->titik_koordinat,
                'status' => $request->status,
            ]);

            return Redirect::back()->with(messageSuccess('Data Mesin Fingerprint Berhasil Di Update'));
        } catch (\Exception $e) {
            return Redirect::back()->with(messageError($e->getMessage()));
        }
    }

    public function destroy($id)
    {
        $id = Crypt::decrypt($id);
        try {
            MesinFingerprint::where('id', $id)->delete();
            return Redirect::back()->with(['success' => 'Data Mesin Fingerprint Berhasil Dihapus']);
        } catch (\Exception $e) {
            return Redirect::back()->with(['error' => $e->getMessage()]);
        }
    }

    /**
     * Menampilkan log mesin presensi
     */
    public function logmesin(Request $request)
    {
        $query = LogMesinPresensi::leftJoin('mesin_fingerprint', 'log_mesin_presensi.id_mesin', '=', 'mesin_fingerprint.id')
            ->select('log_mesin_presensi.*', 'mesin_fingerprint.nama_mesin', 'mesin_fingerprint.sn')
            ->orderBy('log_mesin_presensi.created_at', 'desc');

        if ($request->filled('tanggal')) {
            $query->whereDate('log_mesin_presensi.jam_absen', $request->tanggal);
        }

        $logmesin = $query->paginate(50);
        return view('konfigurasi.mesinfingerprint.logmesin', compact('logmesin'));
    }
}
