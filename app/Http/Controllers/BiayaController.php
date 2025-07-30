<?php

namespace App\Http\Controllers;

use App\Models\Biaya;
use App\Models\Detailbiaya;
use App\Models\Jenisbiaya;
use App\Models\Tahunajaranppdb;
use App\Models\Unit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

class BiayaController extends Controller
{
    public function index(Request $request)
    {
        $tahunajaran = Tahunajaranppdb::where('status', '1')->first();
        $query = Biaya::query();
        $query->join('unit', 'konfigurasi_biaya.kode_unit', '=', 'unit.kode_unit');
        $query->join('konfigurasi_tahun_ajaran', 'konfigurasi_biaya.kode_ta', '=', 'konfigurasi_tahun_ajaran.kode_ta');
        if (!empty($request->kode_ta)) {
            $query->where('konfigurasi_biaya.kode_ta', $request->kode_ta);
        } else {
            $query->where('konfigurasi_biaya.kode_ta', $tahunajaran->kode_ta);
        }

        if (!empty($request->kode_unit)) {
            $query->where('konfigurasi_biaya.kode_unit', $request->kode_unit);
        }
        $data['biaya'] = $query->get();
        $data['tahunajaran'] = Tahunajaranppdb::orderBy('kode_ta')->get();
        $u = new Unit();
        $data['unit'] = $u->getUnit();
        return view('konfigurasi.biaya.index', $data);
    }

    public function create()
    {
        $u = new Unit();
        $data['unit'] = $u->getUnit();
        $data['jenisbiaya'] = Jenisbiaya::orderBy('kode_jenis_biaya')->get();
        $data['tahunajaran'] = Tahunajaranppdb::orderBy('kode_ta')->get();
        return view('konfigurasi.biaya.create', $data);
    }

    public function store(Request $request)
    {
        $request->validate([
            'kode_unit' => 'required',
            'tingkat' => 'required',
            'asrama' => 'required',
            'kode_ta' => 'required'
        ]);

        $tahun_ajaran = str_replace("TA", "", $request->kode_ta);
        $kode_asrama = $request->asrama == 1 ? 'AS' : '';
        $kode_biaya = $request->kode_unit . $request->tingkat . $tahun_ajaran . $kode_asrama;
        $kode_jenis_biaya = $request->kode_jenis_biaya;
        $jumlah = $request->jml;

        if (empty($kode_jenis_biaya)) {
            return Redirect::back()->with(messageError('Detail Biaya Masih kosong'));
        }
        DB::beginTransaction();
        try {
            Biaya::create([
                'kode_biaya' => $kode_biaya,
                'kode_unit' => $request->kode_unit,
                'tingkat' => $request->tingkat,
                'kode_ta' => $request->kode_ta,
                'asrama' => $request->asrama
            ]);

            for ($i = 0; $i < count($kode_jenis_biaya); $i++) {
                echo $i;
                $detail[] = [
                    'kode_biaya' => $kode_biaya,
                    'kode_jenis_biaya' => $kode_jenis_biaya[$i],
                    'jumlah' => toNumber($jumlah[$i])
                ];
            }

            Detailbiaya::insert($detail);
            DB::commit();
            return Redirect::back()->with(messageSuccess('Data Berhasil Disimpan'));
        } catch (\Exception $e) {
            DB::rollBack();
            return Redirect::back()->with(messageError($e->getMessage()));
        }
    }

    public function edit($kode_biaya)
    {
        $kode_biaya = Crypt::decrypt($kode_biaya);
        $data['biaya'] = Biaya::where('kode_biaya', $kode_biaya)
            ->join('unit', 'konfigurasi_biaya.kode_unit', '=', 'unit.kode_unit')
            ->join('konfigurasi_tahun_ajaran', 'konfigurasi_biaya.kode_ta', '=', 'konfigurasi_tahun_ajaran.kode_ta')
            ->first();
        $data['jenisbiaya'] = Jenisbiaya::orderBy('kode_jenis_biaya')->get();
        $data['detail'] = Detailbiaya::join('jenis_biaya', 'konfigurasi_biaya_detail.kode_jenis_biaya', '=', 'jenis_biaya.kode_jenis_biaya')
            ->where('kode_biaya', $kode_biaya)
            ->orderBy('konfigurasi_biaya_detail.kode_jenis_biaya')
            ->get();
        return view('konfigurasi.biaya.edit', $data);
    }


    public function update($kode_biaya, Request $request)
    {

        $kode_biaya = Crypt::decrypt($kode_biaya);
        $kode_jenis_biaya = $request->kode_jenis_biaya;
        $jumlah = $request->jml;

        if (empty($kode_jenis_biaya)) {
            return Redirect::back()->with(messageError('Detail Biaya Masih kosong'));
        }
        DB::beginTransaction();
        try {

            Detailbiaya::where('kode_biaya', $kode_biaya)->delete();

            for ($i = 0; $i < count($kode_jenis_biaya); $i++) {
                echo $i;
                $detail[] = [
                    'kode_biaya' => $kode_biaya,
                    'kode_jenis_biaya' => $kode_jenis_biaya[$i],
                    'jumlah' => toNumber($jumlah[$i])
                ];
            }

            Detailbiaya::insert($detail);
            DB::commit();
            return Redirect::back()->with(messageSuccess('Data Berhasil Di Update'));
        } catch (\Exception $e) {
            DB::rollBack();
            return Redirect::back()->with(messageError($e->getMessage()));
        }
    }


    public function show($kode_biaya)
    {
        $kode_biaya = Crypt::decrypt($kode_biaya);
        $data['biaya'] = Biaya::where('kode_biaya', $kode_biaya)
            ->join('unit', 'konfigurasi_biaya.kode_unit', '=', 'unit.kode_unit')
            ->join('konfigurasi_tahun_ajaran', 'konfigurasi_biaya.kode_ta', '=', 'konfigurasi_tahun_ajaran.kode_ta')
            ->first();
        $data['detail'] = Detailbiaya::join('jenis_biaya', 'konfigurasi_biaya_detail.kode_jenis_biaya', '=', 'jenis_biaya.kode_jenis_biaya')
            ->where('kode_biaya', $kode_biaya)
            ->orderBy('konfigurasi_biaya_detail.kode_jenis_biaya')
            ->get();
        return view('konfigurasi.biaya.show', $data);
    }

    public function destroy($kode_biaya)
    {
        $kode_biaya = Crypt::decrypt($kode_biaya);
        try {
            Biaya::where('kode_biaya', $kode_biaya)->delete();
            return Redirect::back()->with(['success' => 'Data Berhasil Dihapus']);
        } catch (\Exception $e) {
            return Redirect::back()->with(['error' => $e->getMessage()]);
        }
    }
}
