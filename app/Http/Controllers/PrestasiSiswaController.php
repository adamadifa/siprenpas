<?php

namespace App\Http\Controllers;

use App\Models\PrestasiSiswa;
use App\Models\Siswa;
use App\Models\Unit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PrestasiSiswaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $prestasiSiswa = PrestasiSiswa::with(['siswa', 'unit'])->orderBy('created_at', 'desc')->get();
        return view('website.prestasi-siswa.index', compact('prestasiSiswa'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $siswa = Siswa::orderBy('nama_lengkap', 'asc')->get();
        $units = Unit::orderBy('nama_unit', 'asc')->get();
        return view('website.prestasi-siswa.create', compact('siswa', 'units'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'id_siswa' => 'nullable|exists:siswa,id_siswa',
            'kode_unit' => 'required|exists:unit,kode_unit',
            'nama_siswa' => 'required|string|max:255',
            'prestasi' => 'required|string',
            'tingkat' => 'required|in:kecamatan,kabupaten,nasional',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'status' => 'required|boolean'
        ]);

        $data = $request->all();

        if ($request->hasFile('foto')) {
            $foto = $request->file('foto');
            $fotoName = time() . '_' . $foto->getClientOriginalName();
            $foto->storeAs('public/prestasi-siswa', $fotoName);
            $data['foto'] = $fotoName;
        }

        PrestasiSiswa::create($data);

        return redirect()->route('prestasisiswa.index')
            ->with('success', 'Prestasi siswa berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(PrestasiSiswa $prestasiSiswa)
    {
        return view('website.prestasi-siswa.show', compact('prestasiSiswa'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PrestasiSiswa $prestasiSiswa)
    {
        $siswa = Siswa::orderBy('nama_lengkap', 'asc')->get();
        $units = Unit::orderBy('nama_unit', 'asc')->get();
        return view('website.prestasi-siswa.edit', compact('prestasiSiswa', 'siswa', 'units'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, PrestasiSiswa $prestasiSiswa)
    {
        $request->validate([
            'id_siswa' => 'nullable|exists:siswa,id_siswa',
            'kode_unit' => 'required|exists:unit,kode_unit',
            'nama_siswa' => 'required|string|max:255',
            'prestasi' => 'required|string',
            'tingkat' => 'required|in:kecamatan,kabupaten,nasional',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'status' => 'required|boolean'
        ]);

        $data = $request->all();

        if ($request->hasFile('foto')) {
            // Hapus foto lama jika ada
            if ($prestasiSiswa->foto && Storage::exists('public/prestasi-siswa/' . $prestasiSiswa->foto)) {
                Storage::delete('public/prestasi-siswa/' . $prestasiSiswa->foto);
            }

            $foto = $request->file('foto');
            $fotoName = time() . '_' . $foto->getClientOriginalName();
            $foto->storeAs('public/prestasi-siswa', $fotoName);
            $data['foto'] = $fotoName;
        }

        $prestasiSiswa->update($data);

        return redirect()->route('prestasisiswa.index')
            ->with('success', 'Prestasi siswa berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PrestasiSiswa $prestasiSiswa)
    {
        // Hapus foto jika ada
        if ($prestasiSiswa->foto && Storage::exists('public/prestasi-siswa/' . $prestasiSiswa->foto)) {
            Storage::delete('public/prestasi-siswa/' . $prestasiSiswa->foto);
        }

        $prestasiSiswa->delete();

        return redirect()->route('prestasisiswa.index')
            ->with('success', 'Prestasi siswa berhasil dihapus');
    }

    /**
     * Search siswa untuk modal
     */
    public function searchSiswa(Request $request)
    {
        $search = $request->get('search');
        $page = $request->get('page', 1);

        $query = Siswa::query();

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('nama_lengkap', 'like', '%' . $search . '%')
                    ->orWhere('nisn', 'like', '%' . $search . '%');
            });
        }

        $siswa = $query->orderBy('nama_lengkap', 'asc')
            ->paginate(10, ['*'], 'page', $page);

        $html = view('website.prestasi-siswa.partials.siswa-table', compact('siswa'))->render();
        $pagination = $siswa->links()->render();

        return response()->json([
            'html' => $html,
            'pagination' => $pagination
        ]);
    }
}
