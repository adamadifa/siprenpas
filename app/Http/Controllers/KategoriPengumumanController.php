<?php

namespace App\Http\Controllers;

use App\Models\KategoriPengumuman;
use Illuminate\Http\Request;

class KategoriPengumumanController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:kategori-pengumuman.index', ['only' => ['index']]);
        $this->middleware('permission:kategori-pengumuman.create', ['only' => ['create', 'store']]);
        $this->middleware('permission:kategori-pengumuman.show', ['only' => ['show']]);
        $this->middleware('permission:kategori-pengumuman.edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:kategori-pengumuman.destroy', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = KategoriPengumuman::withCount('pengumuman');

        // Search functionality
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where('nama_kategori', 'like', "%{$search}%");
        }

        $kategori = $query->orderBy('nama_kategori')->get();
        return view('kategori-pengumuman.index', compact('kategori'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (request()->ajax()) {
            return view('kategori-pengumuman.create');
        }
        return view('kategori-pengumuman.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_kategori' => 'required|string|max:255|unique:kategori_pengumuman,nama_kategori',
        ]);

        try {
            KategoriPengumuman::create($request->all());
            return redirect()->route('kategori-pengumuman.index')->with('success', 'Kategori pengumuman berhasil ditambahkan');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(KategoriPengumuman $kategoriPengumuman)
    {
        $kategoriPengumuman->load('pengumuman');
        if (request()->ajax()) {
            return view('kategori-pengumuman.show', compact('kategoriPengumuman'));
        }
        return view('kategori-pengumuman.show', compact('kategoriPengumuman'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(KategoriPengumuman $kategoriPengumuman)
    {
        if (request()->ajax()) {
            return view('kategori-pengumuman.edit', compact('kategoriPengumuman'));
        }
        return view('kategori-pengumuman.edit', compact('kategoriPengumuman'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, KategoriPengumuman $kategoriPengumuman)
    {
        $request->validate([
            'nama_kategori' => 'required|string|max:255|unique:kategori_pengumuman,nama_kategori,' . $kategoriPengumuman->id,
        ]);

        try {
            $kategoriPengumuman->update($request->all());
            return redirect()->route('kategori-pengumuman.index')->with('success', 'Kategori pengumuman berhasil diperbarui');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(KategoriPengumuman $kategoriPengumuman)
    {
        try {
            // Check if kategori has pengumuman
            if ($kategoriPengumuman->pengumuman()->count() > 0) {
                return response()->json([
                    'success' => false,
                    'message' => 'Kategori tidak dapat dihapus karena masih memiliki pengumuman'
                ], 422);
            }

            $kategoriPengumuman->delete();

            if (request()->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Kategori pengumuman berhasil dihapus'
                ]);
            }

            return redirect()->route('kategori-pengumuman.index')->with('success', 'Kategori pengumuman berhasil dihapus');
        } catch (\Exception $e) {
            if (request()->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Terjadi kesalahan: ' . $e->getMessage()
                ], 500);
            }

            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}
