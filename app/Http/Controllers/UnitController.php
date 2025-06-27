<?php

namespace App\Http\Controllers;

use App\Models\Unit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Redirect;

class UnitController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Unit::query();
        if (!empty($request->nama_unit_search)) {
            $query->where('nama_unit', 'like', '%' . $request->nama_unit_search . '%');
        }
        $unit = $query->get();
        return view('datamaster.unit.index', compact('unit'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('datamaster.unit.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'kode_unit' => 'required|max:3|min:3|unique:unit,kode_unit',
            'nama_unit' => 'required'
        ]);

        try {
            Unit::create([
                'kode_unit' => $request->kode_unit,
                'nama_unit' => $request->nama_unit
            ]);

            return Redirect::back()->with(messageSuccess('Data Berhasil Disimpan'));
        } catch (\Exception $e) {
            return Redirect::back()->with(messageError($e->getMessage()));
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($kode_unit)
    {
        $kode_unit = Crypt::decrypt($kode_unit);
        $unit = Unit::where('kode_unit', $kode_unit)->first();
        return view('datamaster.unit.edit', compact('unit'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $kode_unit)
    {

        $kode_unit = Crypt::decrypt($kode_unit);
        $request->validate([
            'nama_unit' => 'required'
        ]);
        try {
            Unit::where('kode_unit', $kode_unit)->update([
                'nama_unit' => $request->nama_unit
            ]);

            return Redirect::back()->with(messageSuccess('Data Berhasil Diupdate'));
        } catch (\Exception $e) {
            return Redirect::back()->with(messageError($e->getMessage()));
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($kode_unit)
    {
        $kode_unit = Crypt::decrypt($kode_unit);
        try {
            Unit::where('kode_unit', $kode_unit)->delete();
            return Redirect::back()->with(['success' => 'Data Berhasil Dihapus']);
        } catch (\Exception $e) {
            return Redirect::back()->with(['error' => $e->getMessage()]);
        }
    }

    public function gettingkatbyunit(Request $request)
    {
        $tingkat = config('global.tingkat');
        $jml_tingkat = $tingkat[$request->kode_unit];
        $selected = $request->selected;
        echo "<option value=''>Pilih Tingkat</option>";
        for ($i = 1; $i <= $jml_tingkat; $i++) {
            echo "<option value='$i'" . ($selected == $i ? 'selected' : '') . ">$i</option>";
        }
    }
}
