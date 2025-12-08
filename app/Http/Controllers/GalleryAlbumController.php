<?php

namespace App\Http\Controllers;

use App\Models\GalleryAlbum;
use App\Models\GalleryPhoto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class GalleryAlbumController extends Controller
{
    public function index()
    {
        $albums = GalleryAlbum::withCount('photos')->latest()->paginate(12);
        return view('gallery.index', compact('albums'));
    }

    public function create()
    {
        return view('gallery.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'cover' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:4096',
        ]);

        $data = $request->only(['title', 'description']);

        if ($request->hasFile('cover')) {
            $file = $request->file('cover');
            $name = time() . '_' . $file->getClientOriginalName();
            $path = $file->storeAs('public/gallery/covers', $name);
            $data['cover'] = str_replace('public/', '', $path);
        }

        GalleryAlbum::create($data);

        return redirect()->route('gallery.index')->with('success', 'Album berhasil dibuat.');
    }

    public function edit(GalleryAlbum $gallery)
    {
        return view('gallery.edit', ['album' => $gallery]);
    }

    public function update(Request $request, GalleryAlbum $gallery)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'cover' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:4096',
        ]);

        $data = $request->only(['title', 'description']);

        if ($request->hasFile('cover')) {
            if ($gallery->cover && Storage::exists('public/' . $gallery->cover)) {
                Storage::delete('public/' . $gallery->cover);
            }
            $file = $request->file('cover');
            $name = time() . '_' . $file->getClientOriginalName();
            $path = $file->storeAs('public/gallery/covers', $name);
            $data['cover'] = str_replace('public/', '', $path);
        }

        $gallery->update($data);

        return redirect()->route('gallery.index')->with('success', 'Album berhasil diperbarui.');
    }

    public function destroy(GalleryAlbum $gallery)
    {
        // hapus cover
        if ($gallery->cover && Storage::exists('public/' . $gallery->cover)) {
            Storage::delete('public/' . $gallery->cover);
        }
        // hapus foto-foto
        foreach ($gallery->photos as $photo) {
            if ($photo->path && Storage::exists('public/' . $photo->path)) {
                Storage::delete('public/' . $photo->path);
            }
            $photo->delete();
        }
        $gallery->delete();
        return redirect()->route('gallery.index')->with('success', 'Album berhasil dihapus.');
    }

    public function show(GalleryAlbum $gallery)
    {
        $gallery->load('photos');
        return view('gallery.show', ['album' => $gallery]);
    }

    public function uploadPhoto(Request $request, GalleryAlbum $gallery)
    {
        $request->validate([
            'photos.*' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:4096',
        ]);

        if ($request->hasFile('photos')) {
            foreach ($request->file('photos') as $file) {
                $name = time() . '_' . $file->getClientOriginalName();
                $path = $file->storeAs('public/gallery/photos', $name);
                GalleryPhoto::create([
                    'gallery_album_id' => $gallery->id,
                    'title' => null,
                    'path' => str_replace('public/', '', $path),
                ]);
            }
        }

        return redirect()->route('gallery.show', $gallery->id)->with('success', 'Foto berhasil diunggah.');
    }

    public function destroyPhoto(GalleryAlbum $gallery, GalleryPhoto $photo)
    {
        if ($photo->path && Storage::exists('public/' . $photo->path)) {
            Storage::delete('public/' . $photo->path);
        }
        $photo->delete();

        return redirect()->route('gallery.show', $gallery->id)->with('success', 'Foto berhasil dihapus.');
    }
}


