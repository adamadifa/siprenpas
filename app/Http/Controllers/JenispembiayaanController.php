<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Jenispembiayaan;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Redirect;

class JenispembiayaanController extends Controller
{
    public function index(Request $request)
    {
        $query = Jenispembiayaan::query();
        if (!empty($request->jenis_pembiayaan_search)) {
            $query->where(function($q) use ($request) {
                $q->where('jenis_pembiayaan', 'like', '%' . $request->jenis_pembiayaan_search . '%')
                  ->orWhere('kode_pembiayaan', 'like', '%' . $request->jenis_pembiayaan_search . '%');
            });
        }
        $jenispembiayaan = $query->orderBy('kode_pembiayaan', 'asc')->paginate(10);
        $jenispembiayaan->appends($request->all());
        $data['jenispembiayaan'] = $jenispembiayaan;
        return view('koperasi.jenispembiayaan.index', $data);
    }

    public function create()
    {
        return view('koperasi.jenispembiayaan.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'kode_pembiayaan' => 'required|max:3|min:3|unique:koperasi_jenis_pembiayaan,kode_pembiayaan',
            'jenis_pembiayaan' => 'required',
            'persentase' => 'required|numeric|min:0',
        ], [
            'kode_pembiayaan.required' => 'Kode Pembiayaan wajib diisi',
            'kode_pembiayaan.unique' => 'Kode Pembiayaan ' . strtoupper($request->kode_pembiayaan) . ' sudah digunakan. Silakan gunakan kode lain.',
            'kode_pembiayaan.min' => 'Kode Pembiayaan harus tepat 3 karakter',
            'kode_pembiayaan.max' => 'Kode Pembiayaan harus tepat 3 karakter',
            'jenis_pembiayaan.required' => 'Nama Jenis Pembiayaan wajib diisi',
            'persentase.required' => 'Persentase Margin / Jasa wajib diisi',
            'persentase.numeric' => 'Persentase harus berupa angka yang valid',
            'persentase.min' => 'Persentase tidak boleh kurang dari 0',
        ]);

        try {
            Jenispembiayaan::create([
                'kode_pembiayaan' => strtoupper($request->kode_pembiayaan),
                'jenis_pembiayaan' => $request->jenis_pembiayaan,
                'persentase' => $request->persentase,
            ]);

            return Redirect::back()->with(messageSuccess('Data Jenis Pembiayaan Berhasil Disimpan'));
        } catch (\Exception $e) {
            return Redirect::back()->with(messageError('Gagal menyimpan: ' . $e->getMessage()));
        }
    }

    public function edit($kode_pembiayaan)
    {
        $kode_pembiayaan = Crypt::decrypt($kode_pembiayaan);
        $data['jenispembiayaan'] = Jenispembiayaan::where('kode_pembiayaan', $kode_pembiayaan)->first();
        return view('koperasi.jenispembiayaan.edit', $data);
    }


    public function update(Request $request, $kode_pembiayaan)
    {
        $kode_pembiayaan = Crypt::decrypt($kode_pembiayaan);
        $request->validate([
            'jenis_pembiayaan' => 'required',
            'persentase' => 'required|numeric|min:0',
        ], [
            'jenis_pembiayaan.required' => 'Nama Jenis Pembiayaan wajib diisi',
            'persentase.required' => 'Persentase Margin / Jasa wajib diisi',
            'persentase.numeric' => 'Persentase harus berupa angka yang valid',
            'persentase.min' => 'Persentase tidak boleh kurang dari 0',
        ]);

        try {
            Jenispembiayaan::where('kode_pembiayaan', $kode_pembiayaan)->update([
                'jenis_pembiayaan' => $request->jenis_pembiayaan,
                'persentase' => $request->persentase,
            ]);

            return Redirect::back()->with(messageSuccess('Data Jenis Pembiayaan Berhasil Diupdate'));
        } catch (\Exception $e) {
            return Redirect::back()->with(messageError('Gagal memperbarui: ' . $e->getMessage()));
        }
    }
    public function destroy($kode_pembiayaan)
    {
        $kode_pembiayaan = Crypt::decrypt($kode_pembiayaan);
        try {
            Jenispembiayaan::where('kode_pembiayaan', $kode_pembiayaan)->delete();
            return Redirect::back()->with(messageSuccess('Data Jenis Pembiayaan Berhasil Dihapus'));
        } catch (\Exception $e) {
            return Redirect::back()->with(messageError('Gagal menghapus: ' . $e->getMessage()));
        }
    }
}
