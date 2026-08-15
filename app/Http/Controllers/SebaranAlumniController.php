<?php

namespace App\Http\Controllers;

use App\Models\SebaranAlumni;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\Encoders\WebpEncoder;

class SebaranAlumniController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $items = SebaranAlumni::orderBy('nama_universitas')->paginate(20);
        return view('website.sebaran-alumni.index', compact('items'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('website.sebaran-alumni.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_universitas' => 'required|string|max:255',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,svg,gif,webp|max:4096',
        ]);

        $data = $request->only(['nama_universitas']);
        if ($request->hasFile('logo')) {
            $file = $request->file('logo');
            $name = 'alumni_' . time() . '.webp';
            $data['logo'] = $this->storeAsWebp($file, 'sebaran_alumni', $name);
        }

        SebaranAlumni::create($data);
        return Redirect::route('sebaran-alumni.index')->with(messageSuccess('Data Berhasil Disimpan'));
    }

    /**
     * Display the specified resource.
     */
    public function show(SebaranAlumni $sebaranAlumni)
    {
        return view('website.sebaran-alumni.show', ['item' => $sebaranAlumni]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SebaranAlumni $sebaranAlumni)
    {
        return view('website.sebaran-alumni.edit', ['item' => $sebaranAlumni]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, SebaranAlumni $sebaranAlumni)
    {
        $request->validate([
            'nama_universitas' => 'required|string|max:255',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,svg,gif,webp|max:4096',
        ]);

        $data = $request->only(['nama_universitas']);
        if ($request->hasFile('logo')) {
            if ($sebaranAlumni->logo && Storage::exists('public/' . $sebaranAlumni->logo)) {
                Storage::delete('public/' . $sebaranAlumni->logo);
            }
            $file = $request->file('logo');
            $name = 'alumni_' . time() . '.webp';
            $data['logo'] = $this->storeAsWebp($file, 'sebaran_alumni', $name);
        }

        $sebaranAlumni->update($data);
        return Redirect::route('sebaran-alumni.index')->with(messageSuccess('Data Berhasil Diperbarui'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SebaranAlumni $sebaranAlumni)
    {
        if ($sebaranAlumni->logo && Storage::exists('public/' . $sebaranAlumni->logo)) {
            Storage::delete('public/' . $sebaranAlumni->logo);
        }
        $sebaranAlumni->delete();
        return Redirect::back()->with(messageSuccess('Data Berhasil Dihapus'));
    }
}
