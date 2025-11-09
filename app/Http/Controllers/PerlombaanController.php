<?php

namespace App\Http\Controllers;

use App\Models\Perlombaan;
use App\Models\JenjangPendidikan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Redirect;

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
            'id_jenjang' => 'required|exists:jenjang_pendidikan,id'
        ]);

        try {
            Perlombaan::create([
                'jenis_perlombaan' => $request->jenis_perlombaan,
                'id_jenjang' => $request->id_jenjang
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
            'id_jenjang' => 'required|exists:jenjang_pendidikan,id'
        ]);
        try {
            Perlombaan::where('id', $id)->update([
                'jenis_perlombaan' => $request->jenis_perlombaan,
                'id_jenjang' => $request->id_jenjang
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
            Perlombaan::where('id', $id)->delete();
            return Redirect::back()->with(['success' => 'Data Berhasil Dihapus']);
        } catch (\Exception $e) {
            return Redirect::back()->with(['error' => $e->getMessage()]);
        }
    }
}
