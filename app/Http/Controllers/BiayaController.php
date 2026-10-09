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
        $query->join('konfigurasi_tahunajaran_ppdb', 'konfigurasi_biaya.kode_ta', '=', 'konfigurasi_tahunajaran_ppdb.kode_ta');
        if (!empty($request->kode_ta)) {
            $query->where('konfigurasi_biaya.kode_ta', $request->kode_ta);
        } else {
            if ($tahunajaran) {
                $query->where('konfigurasi_biaya.kode_ta', $tahunajaran->kode_ta);
            }
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
        $kode_pindahan = $request->is_pindahan == 1 ? 'P' : '';
        $kode_biaya = $request->kode_unit . $request->tingkat . $tahun_ajaran . $kode_asrama . $kode_pindahan;
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
                'asrama' => $request->asrama,
                'is_pindahan' => $request->is_pindahan ? 1 : 0
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

    public function duplicateTaModal()
    {
        $data['tahunajaran'] = Tahunajaranppdb::orderBy('kode_ta')->get();
        $u = new Unit();
        $data['unit'] = $u->getUnit();
        return view('konfigurasi.biaya.duplicate_ta', $data);
    }

    public function duplicateTaStore(Request $request)
    {
        $request->validate([
            'kode_ta_from' => 'required',
            'kode_ta_to' => 'required|different:kode_ta_from',
            'overwrite' => 'nullable|in:0,1'
        ], [
            'kode_ta_to.different' => 'Tahun Ajaran Tujuan harus berbeda dengan Tahun Ajaran Asal.'
        ]);

        $query = Biaya::where('kode_ta', $request->kode_ta_from);
        if (!empty($request->kode_unit)) {
            $query->where('kode_unit', $request->kode_unit);
        }
        $sourceBiayas = $query->get();

        if ($sourceBiayas->isEmpty()) {
            return Redirect::back()->with(messageError('Tidak ditemukan data paket biaya pada Tahun Ajaran asal yang dipilih.'));
        }

        $tahun_ajaran_target = str_replace("TA", "", $request->kode_ta_to);
        $overwrite = $request->overwrite == 1;

        $createdCount = 0;
        $updatedCount = 0;
        $skippedCount = 0;

        DB::beginTransaction();
        try {
            foreach ($sourceBiayas as $b) {
                $kode_asrama = $b->asrama == 1 ? 'AS' : '';
                $kode_pindahan = $b->is_pindahan == 1 ? 'P' : '';
                $new_kode_biaya = $b->kode_unit . $b->tingkat . $tahun_ajaran_target . $kode_asrama . $kode_pindahan;

                $sourceDetails = Detailbiaya::where('kode_biaya', $b->kode_biaya)->get();

                $exists = Biaya::where('kode_biaya', $new_kode_biaya)->exists();

                if ($exists) {
                    if ($overwrite) {
                        Biaya::where('kode_biaya', $new_kode_biaya)->update([
                            'kode_unit' => $b->kode_unit,
                            'tingkat' => $b->tingkat,
                            'kode_ta' => $request->kode_ta_to,
                            'asrama' => $b->asrama,
                            'is_pindahan' => $b->is_pindahan
                        ]);

                        Detailbiaya::where('kode_biaya', $new_kode_biaya)->delete();

                        $detailData = [];
                        foreach ($sourceDetails as $detail) {
                            $detailData[] = [
                                'kode_biaya' => $new_kode_biaya,
                                'kode_jenis_biaya' => $detail->kode_jenis_biaya,
                                'jumlah' => $detail->jumlah,
                                'created_at' => now(),
                                'updated_at' => now()
                            ];
                        }
                        if (!empty($detailData)) {
                            Detailbiaya::insert($detailData);
                        }
                        $updatedCount++;
                    } else {
                        $skippedCount++;
                    }
                } else {
                    Biaya::create([
                        'kode_biaya' => $new_kode_biaya,
                        'kode_unit' => $b->kode_unit,
                        'tingkat' => $b->tingkat,
                        'kode_ta' => $request->kode_ta_to,
                        'asrama' => $b->asrama,
                        'is_pindahan' => $b->is_pindahan ? 1 : 0
                    ]);

                    $detailData = [];
                    foreach ($sourceDetails as $detail) {
                        $detailData[] = [
                            'kode_biaya' => $new_kode_biaya,
                            'kode_jenis_biaya' => $detail->kode_jenis_biaya,
                            'jumlah' => $detail->jumlah,
                            'created_at' => now(),
                            'updated_at' => now()
                        ];
                    }
                    if (!empty($detailData)) {
                        Detailbiaya::insert($detailData);
                    }
                    $createdCount++;
                }
            }

            DB::commit();

            $msg = "Duplikasi paket biaya berhasil! Disalin baru: {$createdCount} paket.";
            if ($updatedCount > 0) {
                $msg .= " Diperbarui: {$updatedCount} paket.";
            }
            if ($skippedCount > 0) {
                $msg .= " Dilewati (sudah ada): {$skippedCount} paket.";
            }

            return Redirect::back()->with(messageSuccess($msg));
        } catch (\Exception $e) {
            DB::rollBack();
            return Redirect::back()->with(messageError('Gagal menduplikasi biaya: ' . $e->getMessage()));
        }
    }

    public function duplicate($kode_biaya)
    {
        $kode_biaya = Crypt::decrypt($kode_biaya);
        $data['biaya'] = Biaya::where('kode_biaya', $kode_biaya)
            ->join('unit', 'konfigurasi_biaya.kode_unit', '=', 'unit.kode_unit')
            ->join('konfigurasi_tahunajaran_ppdb', 'konfigurasi_biaya.kode_ta', '=', 'konfigurasi_tahunajaran_ppdb.kode_ta')
            ->first();
        $u = new Unit();
        $data['unit'] = $u->getUnit();
        $data['jenisbiaya'] = Jenisbiaya::orderBy('kode_jenis_biaya')->get();
        $data['tahunajaran'] = Tahunajaranppdb::orderBy('kode_ta')->get();
        $data['detail'] = Detailbiaya::join('jenis_biaya', 'konfigurasi_biaya_detail.kode_jenis_biaya', '=', 'jenis_biaya.kode_jenis_biaya')
            ->where('kode_biaya', $kode_biaya)
            ->orderBy('konfigurasi_biaya_detail.kode_jenis_biaya')
            ->get();
        return view('konfigurasi.biaya.duplicate', $data);
    }

    public function edit($kode_biaya)
    {
        $kode_biaya = Crypt::decrypt($kode_biaya);
        $data['biaya'] = Biaya::where('kode_biaya', $kode_biaya)
            ->join('unit', 'konfigurasi_biaya.kode_unit', '=', 'unit.kode_unit')
            ->join('konfigurasi_tahunajaran_ppdb', 'konfigurasi_biaya.kode_ta', '=', 'konfigurasi_tahunajaran_ppdb.kode_ta')
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

            Biaya::where('kode_biaya', $kode_biaya)->update([
                'is_pindahan' => $request->is_pindahan ? 1 : 0
            ]);

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
            ->join('konfigurasi_tahunajaran_ppdb', 'konfigurasi_biaya.kode_ta', '=', 'konfigurasi_tahunajaran_ppdb.kode_ta')
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
