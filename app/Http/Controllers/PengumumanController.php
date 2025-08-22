<?php

namespace App\Http\Controllers;

use App\Models\Pengumuman;
use App\Models\KategoriPengumuman;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class PengumumanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pengumuman = Pengumuman::with('kategori')->orderBy('tanggal', 'desc')->get();
        $kategori = KategoriPengumuman::all();
        return view('pengumuman.index', compact('pengumuman', 'kategori'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $kategori = KategoriPengumuman::all();
        return view('pengumuman.create', compact('kategori'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'isi' => 'required|string',
            'tanggal' => 'required|date',
            'kategori_id' => 'required|exists:kategori_pengumuman,id',
            'lokasi' => 'nullable|string|max:255',
        ]);

        try {
            Pengumuman::create($request->all());
            return redirect()->route('pengumuman.index')->with('success', 'Pengumuman berhasil ditambahkan');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage())->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Pengumuman $pengumuman)
    {
        return view('pengumuman.show', compact('pengumuman'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Pengumuman $pengumuman)
    {
        $kategori = KategoriPengumuman::all();
        return view('pengumuman.edit', compact('pengumuman', 'kategori'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Pengumuman $pengumuman)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'isi' => 'required|string',
            'tanggal' => 'required|date',
            'kategori_id' => 'required|exists:kategori_pengumuman,id',
            'lokasi' => 'nullable|string|max:255',
        ]);

        try {
            $pengumuman->update($request->all());
            return redirect()->route('pengumuman.index')->with('success', 'Pengumuman berhasil diperbarui');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage())->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Pengumuman $pengumuman)
    {
        try {
            $pengumuman->delete();
            return redirect()->route('pengumuman.index')->with('success', 'Pengumuman berhasil dihapus');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}
