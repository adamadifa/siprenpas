<?php

namespace App\Http\Controllers;

use App\Models\JenjangPendidikan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Redirect;

class JenjangPendidikanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = JenjangPendidikan::query();
        if (!empty($request->jenjang_pendidikan_search)) {
            $query->where('jenjang_pendidikan', 'like', '%' . $request->jenjang_pendidikan_search . '%');
        }
        $jenjangPendidikan = $query->get();
        return view('jenjang-pendidikan.index', compact('jenjangPendidikan'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('jenjang-pendidikan.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'jenjang_pendidikan' => 'required'
        ]);

        try {
            JenjangPendidikan::create([
                'jenjang_pendidikan' => $request->jenjang_pendidikan
            ]);

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
        $jenjangPendidikan = JenjangPendidikan::where('id', $id)->first();
        return view('jenjang-pendidikan.edit', compact('jenjangPendidikan'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $id = Crypt::decrypt($id);
        $request->validate([
            'jenjang_pendidikan' => 'required'
        ]);
        try {
            JenjangPendidikan::where('id', $id)->update([
                'jenjang_pendidikan' => $request->jenjang_pendidikan
            ]);

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
            JenjangPendidikan::where('id', $id)->delete();
            return Redirect::back()->with(['success' => 'Data Berhasil Dihapus']);
        } catch (\Exception $e) {
            return Redirect::back()->with(['error' => $e->getMessage()]);
        }
    }
}
