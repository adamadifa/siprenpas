<?php

namespace App\Http\Controllers;

use App\Models\Page;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Redirect;

class PageController extends Controller
{
    public function index()
    {
        $pages = Page::latest()->paginate(10);
        return view('website.page.index', compact('pages'));
    }

    public function create()
    {
        return view('website.page.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|unique:pages',
            'content' => 'required'
        ]);

        Page::create([
            'title' => $request->title,
            'slug' => \Illuminate\Support\Str::slug($request->title, '-'),
            'content' => $request->content,
            'user_id' => auth()->user()->id
        ]);

        return Redirect::back()->with(messageSuccess('Data Page Berhasil Disimpan'));
    }

    public function edit($id)
    {
        $id = Crypt::decrypt($id);
        $page = Page::findOrFail($id);
        return view('website.page.edit', compact('page'));
    }

    public function update(Request $request, $id)
    {
        $id = Crypt::decrypt($id);
        $page = Page::findOrFail($id);

        $request->validate([
            'title' => 'required|unique:pages,title,' . $id,
            'content' => 'required'
        ]);

        $page->update([
            'title' => $request->title,
            'slug' => \Illuminate\Support\Str::slug($request->title, '-'),
            'content' => $request->content
        ]);

        return Redirect::back()->with(messageSuccess('Data Page Berhasil Diupdate'));
    }

    public function destroy($id)
    {
        $id = Crypt::decrypt($id);
        try {
            Page::where('id', $id)->delete();
            return Redirect::back()->with(messageSuccess('Data Berhasil Dihapus'));
        } catch (\Exception $e) {
            return Redirect::back()->with(messageError($e->getMessage()));
        }
    }

    public function show($slug)
    {
        $page = Page::where('slug', $slug)->firstOrFail();
        return view('website.page.show', compact('page'));
    }

    public function tentangPesantren()
    {
        $page = Page::where('slug', 'tentang-pesantren')->first();
        return view('website.page.tentang-pesantren', compact('page'));
    }

    public function storeOrUpdateTentangPesantren(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'content' => 'required'
        ]);

        $page = Page::where('slug', 'tentang-pesantren')->first();

        if ($page) {
            // Update existing page
            $page->update([
                'title' => $request->title,
                'content' => $request->content,
            ]);
            return Redirect::back()->with(messageSuccess('Data Tentang Pesantren Berhasil Diupdate'));
        } else {
            // Create new page
            Page::create([
                'title' => $request->title,
                'slug' => 'tentang-pesantren',
                'content' => $request->content,
                'user_id' => auth()->user()->id
            ]);
            return Redirect::back()->with(messageSuccess('Data Tentang Pesantren Berhasil Disimpan'));
        }
    }
}
