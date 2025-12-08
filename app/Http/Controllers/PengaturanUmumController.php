<?php

namespace App\Http\Controllers;

use App\Models\PengaturanUmum;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PengaturanUmumController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pengaturan = PengaturanUmum::first();
        return view('settings.pengaturan-umum.index', compact('pengaturan'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('settings.pengaturan-umum.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_aplikasi' => 'nullable|string|max:255',
            'nama_sekolah' => 'required|string|max:255',
            'alamat_sekolah' => 'required|string',
            'telepon' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'website' => 'nullable|url|max:255',
            'facebook' => 'nullable|url|max:255',
            'youtube' => 'nullable|url|max:255',
            'instagram' => 'nullable|url|max:255',
            'tiktok' => 'nullable|url|max:255',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'background_login' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:4096',
            'model_1' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:4096',
            'model_2' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:4096',
            'model_3' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:4096',
            'model_4' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:4096'
        ]);

        $data = $request->all();

        // Handle logo upload
        if ($request->hasFile('logo')) {
            $logo = $request->file('logo');
            $logoName = time() . '.' . $logo->getClientOriginalExtension();
            $logo->storeAs('public/logos', $logoName);
            $data['logo'] = 'logos/' . $logoName;
        }

        // Handle background login upload
        if ($request->hasFile('background_login')) {
            $bg = $request->file('background_login');
            $bgName = 'bg_' . time() . '.' . $bg->getClientOriginalExtension();
            $bg->storeAs('public/backgrounds', $bgName);
            $data['background_login'] = 'backgrounds/' . $bgName;
        }

        // Handle model uploads
        for ($i = 1; $i <= 4; $i++) {
            $fieldName = 'model_' . $i;
            if ($request->hasFile($fieldName)) {
                $model = $request->file($fieldName);
                $modelName = 'model_' . $i . '_' . time() . '.' . $model->getClientOriginalExtension();
                $model->storeAs('public/models', $modelName);
                $data[$fieldName] = 'models/' . $modelName;
            }
        }

        PengaturanUmum::create($data);

        return redirect()->route('pengaturan-umum.index')
            ->with('success', 'Pengaturan umum berhasil disimpan!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $pengaturan = PengaturanUmum::findOrFail($id);
        return view('settings.pengaturan-umum.show', compact('pengaturan'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $pengaturan = PengaturanUmum::findOrFail($id);
        return view('settings.pengaturan-umum.edit', compact('pengaturan'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'nama_aplikasi' => 'nullable|string|max:255',
            'nama_sekolah' => 'required|string|max:255',
            'alamat_sekolah' => 'required|string',
            'telepon' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'website' => 'nullable|url|max:255',
            'facebook' => 'nullable|url|max:255',
            'youtube' => 'nullable|url|max:255',
            'instagram' => 'nullable|url|max:255',
            'tiktok' => 'nullable|url|max:255',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'background_login' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:4096',
            'model_1' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:4096',
            'model_2' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:4096',
            'model_3' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:4096',
            'model_4' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:4096'
        ]);

        $pengaturan = PengaturanUmum::findOrFail($id);
        $data = $request->all();

        // Handle logo upload
        if ($request->hasFile('logo')) {
            // Delete old logo if exists
            if ($pengaturan->logo && Storage::exists('public/' . $pengaturan->logo)) {
                Storage::delete('public/' . $pengaturan->logo);
            }

            $logo = $request->file('logo');
            $logoName = time() . '.' . $logo->getClientOriginalExtension();
            $logo->storeAs('public/logos', $logoName);
            $data['logo'] = 'logos/' . $logoName;
        }

        // Handle background login upload
        if ($request->hasFile('background_login')) {
            if ($pengaturan->background_login && Storage::exists('public/' . $pengaturan->background_login)) {
                Storage::delete('public/' . $pengaturan->background_login);
            }
            $bg = $request->file('background_login');
            $bgName = 'bg_' . time() . '.' . $bg->getClientOriginalExtension();
            $bg->storeAs('public/backgrounds', $bgName);
            $data['background_login'] = 'backgrounds/' . $bgName;
        }

        // Handle model uploads
        for ($i = 1; $i <= 4; $i++) {
            $fieldName = 'model_' . $i;
            if ($request->hasFile($fieldName)) {
                // Delete old model if exists
                $oldModelField = 'model_' . $i;
                if ($pengaturan->$oldModelField && Storage::exists('public/' . $pengaturan->$oldModelField)) {
                    Storage::delete('public/' . $pengaturan->$oldModelField);
                }

                $model = $request->file($fieldName);
                $modelName = 'model_' . $i . '_' . time() . '.' . $model->getClientOriginalExtension();
                $model->storeAs('public/models', $modelName);
                $data[$fieldName] = 'models/' . $modelName;
            }
        }

        $pengaturan->update($data);

        return redirect()->route('pengaturan-umum.index')
            ->with('success', 'Pengaturan umum berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $pengaturan = PengaturanUmum::findOrFail($id);

        // Delete logo if exists
        if ($pengaturan->logo && Storage::exists('public/' . $pengaturan->logo)) {
            Storage::delete('public/' . $pengaturan->logo);
        }

        // Delete background login if exists
        if ($pengaturan->background_login && Storage::exists('public/' . $pengaturan->background_login)) {
            Storage::delete('public/' . $pengaturan->background_login);
        }

        // Delete model files if exists
        for ($i = 1; $i <= 4; $i++) {
            $fieldName = 'model_' . $i;
            if ($pengaturan->$fieldName && Storage::exists('public/' . $pengaturan->$fieldName)) {
                Storage::delete('public/' . $pengaturan->$fieldName);
            }
        }

        $pengaturan->delete();

        return redirect()->route('pengaturan-umum.index')
            ->with('success', 'Pengaturan umum berhasil dihapus!');
    }
}
