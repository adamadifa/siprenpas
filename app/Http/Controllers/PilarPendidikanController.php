<?php

namespace App\Http\Controllers;

use App\Models\PilarPendidikan;
use Illuminate\Http\Request;

class PilarPendidikanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = PilarPendidikan::query();

        if ($request->has('nama_pilar') && !empty($request->nama_pilar)) {
            $query->where('nama_pilar', 'like', '%' . $request->nama_pilar . '%');
        }

        $pilarPendidikan = $query->orderBy('urutan', 'asc')->get();
        return view('website.pilar-pendidikan.index', compact('pilarPendidikan'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('website.pilar-pendidikan.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_pilar' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'urutan' => 'required|integer|min:0',
        ]);

        PilarPendidikan::create($request->all());

        return redirect()->route('pilar-pendidikan.index')
            ->with('success', 'Pilar pendidikan berhasil ditambahkan');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PilarPendidikan $pilarPendidikan)
    {
        return view('website.pilar-pendidikan.edit', compact('pilarPendidikan'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, PilarPendidikan $pilarPendidikan)
    {
        $request->validate([
            'nama_pilar' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'urutan' => 'required|integer|min:0',
        ]);

        $pilarPendidikan->update($request->all());

        return redirect()->route('pilar-pendidikan.index')
            ->with('success', 'Pilar pendidikan berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PilarPendidikan $pilarPendidikan)
    {
        $pilarPendidikan->delete();

        return redirect()->route('pilar-pendidikan.index')
            ->with('success', 'Pilar pendidikan berhasil dihapus');
    }
}

