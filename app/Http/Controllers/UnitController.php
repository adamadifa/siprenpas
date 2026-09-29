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
     * Show form for editing landing page settings of a unit
     */
    public function landingSetting($kode_unit)
    {
        $kode_unit = Crypt::decrypt($kode_unit);
        $unit = Unit::with('landingSetting')->where('kode_unit', $kode_unit)->firstOrFail();
        $setting = $unit->landingSetting ?? new \App\Models\UnitLandingSetting(['kode_unit' => $kode_unit]);

        return view('datamaster.unit.landing_setting', compact('unit', 'setting'));
    }

    /**
     * Update landing page settings for a unit
     */
    public function updateLandingSetting(Request $request, $kode_unit)
    {
        $kode_unit = Crypt::decrypt($kode_unit);
        $unit = Unit::where('kode_unit', $kode_unit)->firstOrFail();

        try {
            $setting = \App\Models\UnitLandingSetting::firstOrNew(['kode_unit' => $kode_unit]);

            // Fill text fields
            $setting->hero_tag = $request->hero_tag;
            $setting->hero_title_prefix = $request->hero_title_prefix;
            $setting->hero_title_highlight = $request->hero_title_highlight;
            $setting->hero_description = $request->hero_description;
            $setting->hero_badge_text = $request->hero_badge_text;
            $setting->hero_badge_subtext = $request->hero_badge_subtext;
            $setting->hero_badge_status = $request->hero_badge_status;
            $setting->hero_badge_icon = $request->hero_badge_icon;

            // Stats
            $setting->stat_1_val = $request->stat_1_val;
            $setting->stat_1_label = $request->stat_1_label;
            $setting->stat_2_val = $request->stat_2_val;
            $setting->stat_2_label = $request->stat_2_label;
            $setting->stat_3_val = $request->stat_3_val;
            $setting->stat_3_label = $request->stat_3_label;
            $setting->stat_4_val = $request->stat_4_val;
            $setting->stat_4_label = $request->stat_4_label;

            // Prakata
            $setting->prakata_tag = $request->prakata_tag;
            $setting->prakata_title = $request->prakata_title;
            $setting->prakata_quote = $request->prakata_quote;
            $setting->prakata_content = $request->prakata_content;
            $setting->prakata_custom_nama = $request->prakata_custom_nama;
            $setting->prakata_custom_jabatan = $request->prakata_custom_jabatan;

            // Program Section Header
            $setting->program_tag = $request->program_tag;
            $setting->program_title = $request->program_title;
            $setting->program_description = $request->program_description;

            // Fasilitas Section Header
            $setting->fasilitas_tag = $request->fasilitas_tag;
            $setting->fasilitas_title = $request->fasilitas_title;
            $setting->fasilitas_description = $request->fasilitas_description;

            // Testimoni Section Header
            $setting->testimoni_tag = $request->testimoni_tag;
            $setting->testimoni_title = $request->testimoni_title;
            $setting->testimoni_description = $request->testimoni_description;

            // CTA Banner
            $setting->cta_tag = $request->cta_tag;
            $setting->cta_title = $request->cta_title;
            $setting->cta_description = $request->cta_description;
            $setting->cta_button_text = $request->cta_button_text;
            $setting->cta_button_url = $request->cta_button_url;
            $setting->cta_wa_text = $request->cta_wa_text;

            // Kontak & Social
            $setting->unit_phone = $request->unit_phone;
            $setting->unit_whatsapp = $request->unit_whatsapp;
            $setting->unit_email = $request->unit_email;
            $setting->unit_instagram = $request->unit_instagram;
            $setting->unit_facebook = $request->unit_facebook;
            $setting->unit_youtube = $request->unit_youtube;

            // Handle File Uploads (WebP Conversion)
            if ($request->hasFile('hero_model_image')) {
                $file = $request->file('hero_model_image');
                $filename = 'hero_model_' . $kode_unit . '_' . time() . '.webp';
                $setting->hero_model_image = $this->storeAsWebp($file, 'landing_units', $filename);
            }

            if ($request->hasFile('prakata_custom_foto')) {
                $file = $request->file('prakata_custom_foto');
                $filename = 'prakata_foto_' . $kode_unit . '_' . time() . '.webp';
                $setting->prakata_custom_foto = $this->storeAsWebp($file, 'landing_units', $filename);
            }

            if ($request->hasFile('cta_model_image')) {
                $file = $request->file('cta_model_image');
                $filename = 'cta_model_' . $kode_unit . '_' . time() . '.webp';
                $setting->cta_model_image = $this->storeAsWebp($file, 'landing_units', $filename);
            }

            // Handle Dynamic Program Unggulan Items & Images
            $customPrograms = $setting->custom_programs ?? [];
            if ($request->has('program_items')) {
                $newPrograms = [];
                foreach ($request->input('program_items') as $pIdx => $pItem) {
                    $pImage = $pItem['old_image'] ?? null;
                    if ($request->hasFile("program_items.{$pIdx}.image")) {
                        $pFile = $request->file("program_items.{$pIdx}.image");
                        $pFilename = 'program_' . $kode_unit . '_' . $pIdx . '_' . time() . '.webp';
                        $pImage = $this->storeAsWebp($pFile, 'landing_units/programs', $pFilename);
                    }
                    $newPrograms[] = [
                        'title' => $pItem['title'] ?? '',
                        'badge' => $pItem['badge'] ?? '',
                        'desc' => $pItem['desc'] ?? '',
                        'icon' => $pItem['icon'] ?? 'ti ti-star',
                        'item_1' => $pItem['item_1'] ?? '',
                        'item_2' => $pItem['item_2'] ?? '',
                        'image' => $pImage,
                    ];
                }
                $setting->custom_programs = $newPrograms;
            }

            // Handle Dynamic Fasilitas Items & Images
            $customFasilitas = $setting->custom_fasilitas ?? [];
            if ($request->has('fasilitas_items')) {
                $newFasilitas = [];
                foreach ($request->input('fasilitas_items') as $idx => $fItem) {
                    $itemImage = $fItem['old_image'] ?? null;
                    if ($request->hasFile("fasilitas_items.{$idx}.image")) {
                        $fFile = $request->file("fasilitas_items.{$idx}.image");
                        $fFilename = 'fasilitas_' . $kode_unit . '_' . $idx . '_' . time() . '.webp';
                        $itemImage = $this->storeAsWebp($fFile, 'landing_units/fasilitas', $fFilename);
                    }
                    $newFasilitas[] = [
                        'tag' => $fItem['tag'] ?? '',
                        'name' => $fItem['name'] ?? '',
                        'desc' => $fItem['desc'] ?? '',
                        'image' => $itemImage,
                    ];
                }
                $setting->custom_fasilitas = $newFasilitas;
            }

            // Handle Dynamic Testimoni Items & Images
            $customTesti = $setting->custom_testimoni ?? [];
            if ($request->has('testimoni_items')) {
                $newTesti = [];
                foreach ($request->input('testimoni_items') as $tIdx => $tItem) {
                    $tAvatar = $tItem['old_avatar'] ?? null;
                    if ($request->hasFile("testimoni_items.{$tIdx}.avatar")) {
                        $tFile = $request->file("testimoni_items.{$tIdx}.avatar");
                        $tFilename = 'testi_' . $kode_unit . '_' . $tIdx . '_' . time() . '.webp';
                        $tAvatar = $this->storeAsWebp($tFile, 'landing_units/testimoni', $tFilename);
                    }
                    $newTesti[] = [
                        'nama' => $tItem['nama'] ?? '',
                        'role' => $tItem['role'] ?? '',
                        'quote' => $tItem['quote'] ?? '',
                        'avatar' => $tAvatar,
                    ];
                }
                $setting->custom_testimoni = $newTesti;
            }

            $setting->save();

            return Redirect::back()->with(messageSuccess('Pengaturan Landing Page Unit Berhasil Disimpan'));
        } catch (\Exception $e) {
            return Redirect::back()->with(messageError('Gagal menyimpan: ' . $e->getMessage()))->withInput();
        }
    }

    /**
     * Convert and compress an uploaded image to WebP, then store it.
     */
    private function storeAsWebp($file, $folder, $filename)
    {
        $imageManager = new ImageManager(new Driver());
        $img = $imageManager->read($file->getRealPath());
        $encoded = $img->encode(new WebpEncoder(quality: 85));

        $path = $folder . '/' . $filename;
        Storage::disk('public')->put($path, (string) $encoded);

        return $path;
    }
}
