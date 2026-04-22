<?php

namespace App\Http\Controllers;

use App\Models\Testimonial;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TestimonialController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Testimonial::query();

        if ($request->has('nama') && !empty($request->nama)) {
            $query->where('nama', 'like', '%' . $request->nama . '%');
        }

        $testimonials = $query->orderBy('created_at', 'desc')->get();
        return view('website.testimonials.index', compact('testimonials'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('website.testimonials.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'testimoni' => 'required|string',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'status' => 'required|boolean'
        ]);

        $data = $request->all();

        if ($request->hasFile('foto')) {
            $foto = $request->file('foto');
            $fotoName = time() . '_' . $foto->getClientOriginalName();
            $foto->storeAs('public/testimonials', $fotoName);
            $data['foto'] = $fotoName;
        }

        Testimonial::create($data);

        return redirect()->route('testimonials.index')
            ->with('success', 'Testimoni berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(Testimonial $testimonial)
    {
        return view('website.testimonials.show', compact('testimonial'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Testimonial $testimonial)
    {
        return view('website.testimonials.edit', compact('testimonial'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Testimonial $testimonial)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'testimoni' => 'required|string',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'status' => 'required|boolean'
        ]);

        $data = $request->all();

        if ($request->hasFile('foto')) {
            // Hapus foto lama jika ada
            if ($testimonial->foto && Storage::exists('public/testimonials/' . $testimonial->foto)) {
                Storage::delete('public/testimonials/' . $testimonial->foto);
            }

            $foto = $request->file('foto');
            $fotoName = time() . '_' . $foto->getClientOriginalName();
            $foto->storeAs('public/testimonials', $fotoName);
            $data['foto'] = $fotoName;
        }

        $testimonial->update($data);

        return redirect()->route('testimonials.index')
            ->with('success', 'Testimoni berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Testimonial $testimonial)
    {
        // Hapus foto jika ada
        if ($testimonial->foto && Storage::exists('public/testimonials/' . $testimonial->foto)) {
            Storage::delete('public/testimonials/' . $testimonial->foto);
        }

        $testimonial->delete();

        return redirect()->route('testimonials.index')
            ->with('success', 'Testimoni berhasil dihapus');
    }
}
