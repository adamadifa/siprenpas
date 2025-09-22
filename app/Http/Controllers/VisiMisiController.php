<?php

namespace App\Http\Controllers;

use App\Models\Misi;
use App\Models\Visi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class VisiMisiController extends Controller
{
    public function index()
    {
        $visi = Visi::first();
        $misi = Misi::orderBy('id')->get();
        return view('website.visimisi.index', compact('visi', 'misi'));
    }

    public function storeVisi(Request $request)
    {
        $request->validate(['deskripsi' => 'required|string']);
        $visi = Visi::first();
        if ($visi) {
            $visi->update(['deskripsi' => $request->deskripsi]);
        } else {
            Visi::create(['deskripsi' => $request->deskripsi]);
        }
        return Redirect::back()->with(messageSuccess('Visi berhasil disimpan'));
    }

    public function storeMisi(Request $request)
    {
        $request->validate([
            'deskripsi' => 'required|string',
            'judul' => 'nullable|string|max:255',
        ]);
        Misi::create($request->only(['judul', 'deskripsi']));
        return Redirect::back()->with(messageSuccess('Misi berhasil ditambahkan'));
    }

    public function updateMisi(Request $request, $id)
    {
        $request->validate([
            'deskripsi' => 'required|string',
            'judul' => 'nullable|string|max:255',
        ]);
        $misi = Misi::findOrFail($id);
        $misi->update($request->only(['judul', 'deskripsi']));
        return Redirect::back()->with(messageSuccess('Misi berhasil diupdate'));
    }

    public function deleteMisi($id)
    {
        $misi = Misi::findOrFail($id);
        $misi->delete();
        return Redirect::back()->with(messageSuccess('Misi berhasil dihapus'));
    }
}
