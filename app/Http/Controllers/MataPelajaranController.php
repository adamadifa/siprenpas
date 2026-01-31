<?php

namespace App\Http\Controllers;

use App\Models\MataPelajaran;
use App\Models\Unit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Redirect;

class MataPelajaranController extends Controller
{
    public function index(Request $request)
    {
        $query = MataPelajaran::with('children')->root();

        // Filter by Kelompok
        if ($request->has('kelompok') && $request->kelompok != '') {
            $query->where('kelompok', $request->kelompok);
        } else {
             // Default Order: Kelompok A, then B..
             $query->orderBy('kelompok');
        }

        // Filter by Unit
        if ($request->has('kode_unit') && $request->kode_unit != '') {
            $query->where('kode_unit', $request->kode_unit);
        }

        // Filter by Nama Mapel
        if ($request->has('nama_matpel') && $request->nama_matpel != '') {
            $query->where('nama_matpel', 'like', '%' . $request->nama_matpel . '%');
        }

        $query->orderBy('urutan');

        $matapelajaran = $query->get();
        $units = Unit::all();

        return view('akademik.mata_pelajaran.index', compact('matapelajaran', 'units'));
    }

    public function create()
    {
        $units = Unit::all();
        // Get all parents for dropdown
        $parents = MataPelajaran::root()->orderBy('kelompok')->orderBy('nama_matpel')->get();

        return view('akademik.mata_pelajaran.create', compact('units', 'parents'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_matpel' => 'required',
            'kelompok' => 'required',
            'kode_unit' => 'required',
            'urutan' => 'required|numeric'
        ]);

        try {
            // Generate Kode Mapel: MP + KodeUnit + 001 (Sequence)
            $lastMapel = MataPelajaran::where('kode_unit', $request->kode_unit)
                ->orderByRaw('LENGTH(kode_matpel) DESC')
                ->orderBy('kode_matpel', 'desc')
                ->first();

            $nextNumber = 1;
            if ($lastMapel && $lastMapel->kode_matpel) {
                // Extract number from end
                $lastCode = $lastMapel->kode_matpel;
                // Asumsi format MP + U04 + XXX (total length variable depend on unit code len)
                // MP = 2 chars
                // Unit = 3 chars (U04)
                // Total prefix = 5 chars
                // Check if code matches pattern
                if (preg_match('/^MP' . $request->kode_unit . '(\d+)$/', $lastCode, $matches)) {
                    $nextNumber = intval($matches[1]) + 1;
                }
            }

            $kodeMatpel = 'MP' . $request->kode_unit . str_pad($nextNumber, 3, '0', STR_PAD_LEFT);

            MataPelajaran::create([
                'kode_unit' => $request->kode_unit,
                'kode_matpel' => $kodeMatpel,
                'nama_matpel' => $request->nama_matpel,
                'kelompok' => $request->kelompok,
                'parent_id' => $request->parent_id,
                'urutan' => $request->urutan,
                'aktif' => $request->has('aktif') ? 1 : 0
            ]);

            return Redirect::route('mata-pelajaran.index')->with(['success' => 'Data Berhasil Disimpan']);
        } catch (\Exception $e) {
            return Redirect::back()->with(['warning' => 'Data Gagal Disimpan: ' . $e->getMessage()]);
        }
    }

    public function edit($id)
    {
        $id = Crypt::decrypt($id);
        $matapelajaran = MataPelajaran::findOrFail($id);
        $units = Unit::all();
        $parents = MataPelajaran::root()->where('id', '!=', $id)->orderBy('kelompok')->orderBy('nama_matpel')->get();

        return view('akademik.mata_pelajaran.edit', compact('matapelajaran', 'units', 'parents'));
    }

    public function update(Request $request, $id)
    {
        $id = Crypt::decrypt($id);
        $request->validate([
            'nama_matpel' => 'required',
            'kelompok' => 'required',
            'urutan' => 'required|numeric'
        ]);

        try {
            $matapelajaran = MataPelajaran::findOrFail($id);
            $matapelajaran->update([
                'kode_unit' => $request->kode_unit,
                'kode_matpel' => $request->kode_matpel,
                'nama_matpel' => $request->nama_matpel,
                'kelompok' => $request->kelompok,
                'parent_id' => $request->parent_id,
                'urutan' => $request->urutan,
                'aktif' => $request->has('aktif') ? 1 : 0
            ]);

            return Redirect::route('mata-pelajaran.index')->with(['success' => 'Data Berhasil Diupdate']);
        } catch (\Exception $e) {
            return Redirect::back()->with(['warning' => 'Data Gagal Diupdate: ' . $e->getMessage()]);
        }
    }

    public function destroy($id)
    {
        $id = Crypt::decrypt($id);
        try {
            $matapelajaran = MataPelajaran::findOrFail($id);
            $matapelajaran->delete();
            return Redirect::back()->with(['success' => 'Data Berhasil Dihapus']);
        } catch (\Exception $e) {
            return Redirect::back()->with(['warning' => 'Data Gagal Dihapus: ' . $e->getMessage()]);
        }
    }
}
