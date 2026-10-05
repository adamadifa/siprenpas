<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Jenissimpanan;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Redirect;

class JenissimpananController extends Controller
{
    public function index(Request $request)
    {
        $query = Jenissimpanan::query();
        if (!empty($request->jenis_simpanan_search)) {
            $query->where(function($q) use ($request) {
                $q->where('jenis_simpanan', 'like', '%' . $request->jenis_simpanan_search . '%')
                  ->orWhere('kode_simpanan', 'like', '%' . $request->jenis_simpanan_search . '%');
            });
        }
        $jenissimpanan = $query->orderBy('kode_simpanan', 'asc')->paginate(10);
        $jenissimpanan->appends($request->all());
        $data['jenissimpanan'] = $jenissimpanan;
        return view('koperasi.jenissimpanan.index', $data);
    }

    public function create()
    {
        return view('koperasi.jenissimpanan.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'kode_simpanan' => 'required|max:3|min:3|unique:koperasi_jenis_simpanan,kode_simpanan',
            'jenis_simpanan' => 'required',
        ], [
            'kode_simpanan.required' => 'Kode Simpanan wajib diisi',
            'kode_simpanan.unique' => 'Kode Simpanan ' . strtoupper($request->kode_simpanan) . ' sudah digunakan. Silakan gunakan kode lain.',
            'kode_simpanan.min' => 'Kode Simpanan harus tepat 3 karakter',
            'kode_simpanan.max' => 'Kode Simpanan harus tepat 3 karakter',
            'jenis_simpanan.required' => 'Nama Jenis Simpanan wajib diisi',
        ]);

        try {
            Jenissimpanan::create([
                'kode_simpanan' => strtoupper($request->kode_simpanan),
                'jenis_simpanan' => $request->jenis_simpanan,
            ]);

            return Redirect::back()->with(messageSuccess('Data Jenis Simpanan Berhasil Disimpan'));
        } catch (\Exception $e) {
            return Redirect::back()->with(messageError('Gagal menyimpan: ' . $e->getMessage()));
        }
    }

    public function edit($kode_simpanan)
    {
        $kode_simpanan = Crypt::decrypt($kode_simpanan);
        $data['jenissimpanan'] = Jenissimpanan::where('kode_simpanan', $kode_simpanan)->first();
        return view('koperasi.jenissimpanan.edit', $data);
    }


    public function update(Request $request, $kode_simpanan)
    {
        $kode_simpanan = Crypt::decrypt($kode_simpanan);
        $request->validate([
            'jenis_simpanan' => 'required',
        ], [
            'jenis_simpanan.required' => 'Nama Jenis Simpanan wajib diisi',
        ]);

        try {
            Jenissimpanan::where('kode_simpanan', $kode_simpanan)->update([
                'jenis_simpanan' => $request->jenis_simpanan,
            ]);

            return Redirect::back()->with(messageSuccess('Data Jenis Simpanan Berhasil Diupdate'));
        } catch (\Exception $e) {
            return Redirect::back()->with(messageError('Gagal memperbarui: ' . $e->getMessage()));
        }
    }
    public function destroy($kode_simpanan)
    {
        $kode_simpanan = Crypt::decrypt($kode_simpanan);
        try {
            Jenissimpanan::where('kode_simpanan', $kode_simpanan)->delete();
            return Redirect::back()->with(messageSuccess('Data Jenis Simpanan Berhasil Dihapus'));
        } catch (\Exception $e) {
            return Redirect::back()->with(messageError('Gagal menghapus: ' . $e->getMessage()));
        }
    }
}
