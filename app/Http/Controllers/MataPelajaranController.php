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
        $query = MataPelajaran::with(['children.unit', 'unit'])->root();

        // Filter by Kelompok
        if ($request->has('kelompok') && $request->kelompok != '') {
            $query->where('kelompok', $request->kelompok);
        } else {
            // Default Order: Kelompok A, then B..
            $query->orderBy('kelompok');
        }

        // Filter by Unit
        if (!auth()->user()->hasRole('super admin')) {
            $query->where('kode_unit', auth()->user()->kode_unit);
            $units = Unit::where('kode_unit', auth()->user()->kode_unit)->get();
        } else {
            if ($request->has('kode_unit') && $request->kode_unit != '') {
                $query->where('kode_unit', $request->kode_unit);
            }
            $units = Unit::all();
        }

        // Filter by Nama Mapel or Kode Mapel
        if ($request->has('nama_matpel') && $request->nama_matpel != '') {
            $query->where(function ($q) use ($request) {
                $q->where('nama_matpel', 'like', '%' . $request->nama_matpel . '%')
                    ->orWhere('kode_matpel', 'like', '%' . $request->nama_matpel . '%')
                    ->orWhereHas('children', function ($cq) use ($request) {
                        $cq->where('nama_matpel', 'like', '%' . $request->nama_matpel . '%')
                            ->orWhere('kode_matpel', 'like', '%' . $request->nama_matpel . '%');
                    });
            });
        }

        $query->orderBy('urutan');

        $matapelajaran = $query->get();

        return view('akademik.mata_pelajaran.index', compact('matapelajaran', 'units'));
    }

    public function create()
    {
        if (!auth()->user()->hasRole('super admin')) {
            $units = Unit::where('kode_unit', auth()->user()->kode_unit)->get();
        } else {
            $units = Unit::all();
        }

        // Get all parents for dropdown
        $parentsQuery = MataPelajaran::root()->orderBy('kelompok')->orderBy('nama_matpel');
        if (!auth()->user()->hasRole('super admin')) {
            $parentsQuery->where('kode_unit', auth()->user()->kode_unit);
        }
        $parents = $parentsQuery->get();

        return view('akademik.mata_pelajaran.create', compact('units', 'parents'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_matpel' => 'required',
            'kelompok' => 'required',
            'kode_unit' => 'required',
            'urutan' => 'required|numeric'
        ], [
            'nama_matpel.required' => 'Nama Mata Pelajaran wajib diisi',
            'kelompok.required' => 'Kelompok Mata Pelajaran wajib dipilih',
            'kode_unit.required' => 'Unit pendidikan wajib dipilih',
            'urutan.required' => 'Urutan mata pelajaran wajib diisi',
            'urutan.numeric' => 'Urutan harus berupa angka'
        ]);

        try {
            // Generate Kode Mapel: MP + KodeUnit + 001 (Sequence)
            $lastMapel = MataPelajaran::where('kode_unit', $request->kode_unit)
                ->orderByRaw('LENGTH(kode_matpel) DESC')
                ->orderBy('kode_matpel', 'desc')
                ->first();

            $nextNumber = 1;
            if ($lastMapel && $lastMapel->kode_matpel) {
                $lastCode = $lastMapel->kode_matpel;
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
                'parent_id' => $request->parent_id ?: null,
                'urutan' => $request->urutan,
                'aktif' => $request->has('aktif') ? 1 : 0
            ]);

            return Redirect::route('mata-pelajaran.index')->with(messageSuccess('Data Mata Pelajaran Berhasil Disimpan'));
        } catch (\Exception $e) {
            return Redirect::back()->with(messageError('Data Gagal Disimpan: ' . $e->getMessage()));
        }
    }

    public function edit($id)
    {
        $id = Crypt::decrypt($id);
        $matapelajaran = MataPelajaran::findOrFail($id);

        if (!auth()->user()->hasRole('super admin')) {
            $units = Unit::where('kode_unit', auth()->user()->kode_unit)->get();
        } else {
            $units = Unit::all();
        }

        $parentsQuery = MataPelajaran::root()->where('id', '!=', $id)->orderBy('kelompok')->orderBy('nama_matpel');
        if (!auth()->user()->hasRole('super admin')) {
            $parentsQuery->where('kode_unit', auth()->user()->kode_unit);
        }
        $parents = $parentsQuery->get();

        return view('akademik.mata_pelajaran.edit', compact('matapelajaran', 'units', 'parents'));
    }

    public function update(Request $request, $id)
    {
        $id = Crypt::decrypt($id);
        $request->validate([
            'nama_matpel' => 'required',
            'kelompok' => 'required',
            'urutan' => 'required|numeric'
        ], [
            'nama_matpel.required' => 'Nama Mata Pelajaran wajib diisi',
            'kelompok.required' => 'Kelompok Mata Pelajaran wajib dipilih',
            'urutan.required' => 'Urutan mata pelajaran wajib diisi',
            'urutan.numeric' => 'Urutan harus berupa angka'
        ]);

        try {
            $matapelajaran = MataPelajaran::findOrFail($id);
            $matapelajaran->update([
                'kode_unit' => $request->kode_unit ?? $matapelajaran->kode_unit,
                'kode_matpel' => $request->kode_matpel ?? $matapelajaran->kode_matpel,
                'nama_matpel' => $request->nama_matpel,
                'kelompok' => $request->kelompok,
                'parent_id' => $request->parent_id ?: null,
                'urutan' => $request->urutan,
                'aktif' => $request->has('aktif') ? 1 : 0
            ]);

            return Redirect::route('mata-pelajaran.index')->with(messageSuccess('Data Mata Pelajaran Berhasil Diupdate'));
        } catch (\Exception $e) {
            return Redirect::back()->with(messageError('Data Gagal Diupdate: ' . $e->getMessage()));
        }
    }

    public function destroy($id)
    {
        $id = Crypt::decrypt($id);
        try {
            $matapelajaran = MataPelajaran::findOrFail($id);
            // Delete child sub-matpel if any
            $matapelajaran->children()->delete();
            $matapelajaran->delete();
            return Redirect::back()->with(messageSuccess('Data Mata Pelajaran Berhasil Dihapus'));
        } catch (\Exception $e) {
            return Redirect::back()->with(messageError('Data Gagal Dihapus: ' . $e->getMessage()));
        }
    }
}
