<?php

namespace App\Http\Controllers;

use App\Models\Jabatan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Redirect;

class JabatanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Jabatan::query();
        $query->where('kode_jabatan', '!=', 'J00');
        if (!empty($request->nama_jabatan)) {
            $query->where('nama_jabatan', 'like', '%' . $request->nama_jabatan . '%');
        }
        $jabatan = $query->orderBy('kode_jabatan', 'asc')->get();
        return view('datamaster.jabatan.index', compact('jabatan'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('datamaster.jabatan.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'kode_jabatan' => 'required|max:3|min:3|unique:jabatan,kode_jabatan',
            'nama_jabatan' => 'required'
        ], [
            'kode_jabatan.required' => 'Kode Jabatan wajib diisi',
            'kode_jabatan.unique' => 'Kode Jabatan ' . strtoupper($request->kode_jabatan) . ' sudah digunakan. Silakan gunakan kode lain.',
            'kode_jabatan.min' => 'Kode Jabatan harus tepat 3 karakter',
            'kode_jabatan.max' => 'Kode Jabatan harus tepat 3 karakter',
            'nama_jabatan.required' => 'Nama Jabatan wajib diisi',
        ]);

        try {
            Jabatan::create([
                'kode_jabatan' => strtoupper($request->kode_jabatan),
                'nama_jabatan' => $request->nama_jabatan
            ]);

            return Redirect::back()->with(messageSuccess('Data Jabatan Berhasil Disimpan'));
        } catch (\Exception $e) {
            return Redirect::back()->with(messageError('Gagal menyimpan: ' . $e->getMessage()));
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
    public function edit($kode_jabatan)
    {
        $kode_jabatan = Crypt::decrypt($kode_jabatan);
        $jabatan = Jabatan::where('kode_jabatan', $kode_jabatan)->first();
        return view('datamaster.jabatan.edit', compact('jabatan'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $kode_jabatan)
    {
        $kode_jabatan = Crypt::decrypt($kode_jabatan);
        $request->validate([
            'nama_jabatan' => 'required'
        ], [
            'nama_jabatan.required' => 'Nama Jabatan wajib diisi',
        ]);
        try {
            Jabatan::where('kode_jabatan', $kode_jabatan)->update([
                'nama_jabatan' => $request->nama_jabatan
            ]);

            return Redirect::back()->with(messageSuccess('Data Jabatan Berhasil Diupdate'));
        } catch (\Exception $e) {
            return Redirect::back()->with(messageError('Gagal memperbarui: ' . $e->getMessage()));
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($kode_jabatan)
    {
        $kode_jabatan = Crypt::decrypt($kode_jabatan);
        try {
            Jabatan::where('kode_jabatan', $kode_jabatan)->delete();
            return Redirect::back()->with(['success' => 'Data Berhasil Dihapus']);
        } catch (\Exception $e) {
            return Redirect::back()->with(['error' => $e->getMessage()]);
        }
    }
}
