<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Str;

class KategoriController extends Controller
{
    public function index(Request $request)
    {
        $query = Category::query();
        $kategori = $query->get();
        return view('website.kategori.index', compact('kategori'));
    }

    public function create()
    {
        return view('website.kategori.create');
    }

    public function store(Request $request)
    {

        try {
            $kategori = new Category();
            $kategori->name = $request->kategori;
            $kategori->slug = Str::slug($request->kategori);

            $kategori->save();
            return Redirect::back()->with(messageSuccess('Kategori Berhasil Ditambahkan'));
        } catch (\Exception $e) {
            return Redirect::back()->with(messageError('Kategori Gagal Ditambahkan', $e->getMessage()));
        }
    }

    public function edit($id)
    {
        $id = Crypt::decrypt($id);
        $kategori = Category::findorFail($id);
        $data['kategori'] = $kategori;
        return view('website.kategori.edit', $data);
    }

    public function update(Request $request, $id)
    {
        $id = Crypt::decrypt($id);
        try {
            $kategori = Category::findorFail($id);
            $kategori->name = $request->kategori;
            $kategori->slug = Str::slug($request->kategori);
            $kategori->save();
            return Redirect::back()->with(messageSuccess('Kategori Berhasil Diubah'));
        } catch (\Exception $e) {
            return Redirect::back()->with(messageError('Kategori Gagal Diubah', $e->getMessage()));
        }
    }

    public function destroy($id)
    {
        $id = Crypt::decrypt($id);
        try {
            $kategori = Category::findorFail($id);
            $kategori->delete();
            return Redirect::back()->with(messageSuccess('Kategori Berhasil Dihapus'));
        } catch (\Exception $e) {
            return Redirect::back()->with(messageError('Kategori Gagal Dihapus', $e->getMessage()));
        }
    }
}
