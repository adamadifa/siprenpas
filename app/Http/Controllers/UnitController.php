<?php

namespace App\Http\Controllers;

use App\Models\Unit;
use App\Models\Kelas;
use App\Models\Guru;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\Encoders\WebpEncoder;

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
            'nama_unit' => 'required',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:4096',
            'status' => 'required|in:0,1'
        ]);

        try {
            $data = [
                'kode_unit' => $request->kode_unit,
                'nama_unit' => $request->nama_unit,
                'status' => $request->status ?? 1,
                'keterangan' => $request->keterangan
            ];

            // Handle logo upload
            if ($request->hasFile('logo')) {
                $logo = $request->file('logo');
                $logoName = 'unit_' . $request->kode_unit . '_' . time() . '.webp';
                $data['logo'] = $this->storeAsWebp($logo, 'unit_logos', $logoName);
            }

            Unit::create($data);

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
            'nama_unit' => 'required',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:4096',
            'status' => 'required|in:0,1'
        ]);
        try {
            $unit = Unit::where('kode_unit', $kode_unit)->first();
            $data = [
                'nama_unit' => $request->nama_unit,
                'status' => $request->status ?? 1,
                'keterangan' => $request->keterangan
            ];

            // Handle logo upload
            if ($request->hasFile('logo')) {
                // Delete old logo if exists
                if ($unit->logo && Storage::exists('public/' . $unit->logo)) {
                    Storage::delete('public/' . $unit->logo);
                }

                $logo = $request->file('logo');
                $logoName = 'unit_' . $kode_unit . '_' . time() . '.webp';
                $data['logo'] = $this->storeAsWebp($logo, 'unit_logos', $logoName);
            }

            Unit::where('kode_unit', $kode_unit)->update($data);

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
            $unit = Unit::where('kode_unit', $kode_unit)->first();
            
            // Delete logo if exists
            if ($unit && $unit->logo && Storage::exists('public/' . $unit->logo)) {
                Storage::delete('public/' . $unit->logo);
            }

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
        echo "<option value=''>Tingkat</option>";
        for ($i = 1; $i <= $jml_tingkat; $i++) {
            echo "<option value='$i'" . ($selected == $i ? 'selected' : '') . ">$i</option>";
        }
    }

    public function getkelasbytingkat(Request $request)
    {
        $kode_unit = $request->kode_unit;
        $tingkat = $request->tingkat;
        $kode_ta = $request->kode_ta;
        $selected = $request->selected;

        $query = Kelas::query();
        if (!empty($kode_unit)) {
            $query->where('kode_unit', $kode_unit);
        }
        if (!empty($tingkat)) {
            $query->where('tingkat', $tingkat);
        }
        if (!empty($kode_ta)) {
            $query->where('kode_ta', $kode_ta);
        }
        
        $kelas = $query->orderBy('nama_kelas')->get();

        echo "<option value=''>Kelas</option>";
        foreach ($kelas as $k) {
            echo "<option value='{$k->kode_kelas}'" . ($selected == $k->kode_kelas ? 'selected' : '') . ">{$k->nama_kelas}</option>";
        }
    }

    public function getgurubyunit(Request $request)
    {
        $kode_unit = $request->kode_unit;
        $selected = $request->selected;

        $query = Guru::with('karyawan')->where('status_aktif_ajar', 1);
        if (!empty($kode_unit)) {
            $query->where('kode_unit', $kode_unit);
        }
        $gurus = $query->get()->sortBy(function($g) {
            return $g->karyawan->nama_lengkap ?? '';
        });

        echo "<option value=''>Pilih Wali Kelas</option>";
        foreach ($gurus as $g) {
            $nama = $g->karyawan->nama_lengkap ?? $g->nama_guru;
            echo "<option value='{$g->id}'" . ($selected == $g->id ? 'selected' : '') . ">{$nama}</option>";
        }
    }

    /**
     * Convert and compress an uploaded image to WebP, then store it.
     */
    private function storeAsWebp($file, $folder, $filename)
    {
        $imageManager = new ImageManager(new Driver());
        $img = $imageManager->read($file->getRealPath());
        $encoded = $img->encode(new WebpEncoder(quality: 80));

        $path = $folder . '/' . $filename;
        Storage::put('public/' . $path, (string) $encoded);

        return $path;
    }
}
