<?php

namespace App\Http\Controllers;

use App\Models\ProgramUnggulan;
use Illuminate\Http\Request;

class ProgramUnggulanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = ProgramUnggulan::query();

        if ($request->has('nama_program') && !empty($request->nama_program)) {
            $query->where('nama_program', 'like', '%' . $request->nama_program . '%');
        }

        $programUnggulan = $query->orderBy('urutan', 'asc')->get();
        return view('website.program-unggulan.index', compact('programUnggulan'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('website.program-unggulan.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_program' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'urutan' => 'required|integer|min:0'
        ]);

        ProgramUnggulan::create($request->all());

        return redirect()->route('program-unggulan.index')
            ->with('success', 'Program unggulan berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(ProgramUnggulan $programUnggulan)
    {
        return view('website.program-unggulan.show', compact('programUnggulan'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ProgramUnggulan $programUnggulan)
    {
        return view('website.program-unggulan.edit', compact('programUnggulan'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ProgramUnggulan $programUnggulan)
    {
        $request->validate([
            'nama_program' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'urutan' => 'required|integer|min:0'
        ]);

        $programUnggulan->update($request->all());

        return redirect()->route('program-unggulan.index')
            ->with('success', 'Program unggulan berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ProgramUnggulan $programUnggulan)
    {
        $programUnggulan->delete();

        return redirect()->route('program-unggulan.index')
            ->with('success', 'Program unggulan berhasil dihapus');
    }
}
