<?php

namespace App\Http\Controllers;

use App\Models\Perlombaan;
use App\Models\JenjangPendidikan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;

class PerlombaanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Perlombaan::with('jenjangPendidikan');
        if (!empty($request->jenis_perlombaan_search)) {
            $query->where('jenis_perlombaan', 'like', '%' . $request->jenis_perlombaan_search . '%');
        }
        if (!empty($request->id_jenjang_search)) {
            $query->where('id_jenjang', $request->id_jenjang_search);
        }
        $perlombaan = $query->get();
        $jenjangPendidikan = JenjangPendidikan::orderBy('jenjang_pendidikan')->get();
        return view('perlombaan.index', compact('perlombaan', 'jenjangPendidikan'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $jenjangPendidikan = JenjangPendidikan::orderBy('jenjang_pendidikan')->get();
        return view('perlombaan.create', compact('jenjangPendidikan'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'jenis_perlombaan' => 'required',
            'id_jenjang' => 'required|exists:jenjang_pendidikan,id',
            'biaya_pendaftaran' => 'required|numeric|min:0',
            'contact_person' => 'required|string|max:255',
            'juknis_juklak' => 'nullable|file|mimes:pdf,doc,docx|max:10240',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048'
        ]);

        try {
            $data = [
                'jenis_perlombaan' => $request->jenis_perlombaan,
                'id_jenjang' => $request->id_jenjang,
                'biaya_pendaftaran' => $request->biaya_pendaftaran,
                'contact_person' => $request->contact_person,
            ];

            // Handle file upload juknis_juklak
            if ($request->hasFile('juknis_juklak')) {
                $file = $request->file('juknis_juklak');
                $fileName = time() . '_' . $file->getClientOriginalName();
                $file->storeAs('public/juknis_juklak', $fileName);
                $data['juknis_juklak'] = 'juknis_juklak/' . $fileName;
            }

            // Handle thumbnail upload
            if ($request->hasFile('thumbnail')) {
                $thumbnail = $request->file('thumbnail');
                $thumbnailName = time() . '_' . $thumbnail->getClientOriginalName();
                $thumbnail->storeAs('public/thumbnails', $thumbnailName);
                $data['thumbnail'] = 'thumbnails/' . $thumbnailName;
            }

            Perlombaan::create($data);

            return Redirect::back()->with(messageSuccess('Data Berhasil Disimpan'));
        } catch (\Exception $e) {
            return Redirect::back()->with(messageError($e->getMessage()));
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
    public function edit($id)
    {
        $id = Crypt::decrypt($id);
        $perlombaan = Perlombaan::where('id', $id)->first();
        $jenjangPendidikan = JenjangPendidikan::orderBy('jenjang_pendidikan')->get();
        return view('perlombaan.edit', compact('perlombaan', 'jenjangPendidikan'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $id = Crypt::decrypt($id);
        $request->validate([
            'jenis_perlombaan' => 'required',
            'id_jenjang' => 'required|exists:jenjang_pendidikan,id',
            'biaya_pendaftaran' => 'required|numeric|min:0',
            'contact_person' => 'required|string|max:255',
            'juknis_juklak' => 'nullable|file|mimes:pdf,doc,docx|max:10240',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048'
        ]);
        try {
            $perlombaan = Perlombaan::where('id', $id)->first();
            
            $data = [
                'jenis_perlombaan' => $request->jenis_perlombaan,
                'id_jenjang' => $request->id_jenjang,
                'biaya_pendaftaran' => $request->biaya_pendaftaran,
                'contact_person' => $request->contact_person,
            ];

            // Handle file upload juknis_juklak
            if ($request->hasFile('juknis_juklak')) {
                // Delete old file if exists
                if ($perlombaan->juknis_juklak && Storage::exists('public/' . $perlombaan->juknis_juklak)) {
                    Storage::delete('public/' . $perlombaan->juknis_juklak);
                }

                $file = $request->file('juknis_juklak');
                $fileName = time() . '_' . $file->getClientOriginalName();
                $file->storeAs('public/juknis_juklak', $fileName);
                $data['juknis_juklak'] = 'juknis_juklak/' . $fileName;
            }

            // Handle thumbnail upload
            if ($request->hasFile('thumbnail')) {
                // Delete old thumbnail if exists
                if ($perlombaan->thumbnail && Storage::exists('public/' . $perlombaan->thumbnail)) {
                    Storage::delete('public/' . $perlombaan->thumbnail);
                }

                $thumbnail = $request->file('thumbnail');
                $thumbnailName = time() . '_' . $thumbnail->getClientOriginalName();
                $thumbnail->storeAs('public/thumbnails', $thumbnailName);
                $data['thumbnail'] = 'thumbnails/' . $thumbnailName;
            }

            Perlombaan::where('id', $id)->update($data);

            return Redirect::back()->with(messageSuccess('Data Berhasil Diupdate'));
        } catch (\Exception $e) {
            return Redirect::back()->with(messageError($e->getMessage()));
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $id = Crypt::decrypt($id);
        try {
            $perlombaan = Perlombaan::where('id', $id)->first();
            
            // Delete file if exists
            if ($perlombaan->juknis_juklak && Storage::exists('public/' . $perlombaan->juknis_juklak)) {
                Storage::delete('public/' . $perlombaan->juknis_juklak);
            }

            // Delete thumbnail if exists
            if ($perlombaan->thumbnail && Storage::exists('public/' . $perlombaan->thumbnail)) {
                Storage::delete('public/' . $perlombaan->thumbnail);
            }
            
            Perlombaan::where('id', $id)->delete();
            return Redirect::back()->with(['success' => 'Data Berhasil Dihapus']);
        } catch (\Exception $e) {
            return Redirect::back()->with(['error' => $e->getMessage()]);
        }
    }
}
