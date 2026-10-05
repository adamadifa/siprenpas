<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kegiatanibadah;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Redirect;
use App\Http\Controllers\Controller;
use App\Models\Kategoriibadah;

class KegiatanibadahController extends Controller
{

    public function index(Request $request)
    {
        $query = Kegiatanibadah::query();
        $query->select('kegiatan_ibadah.*', 'kategori_ibadah.kategori_ibadah');
        $query->join('kategori_ibadah', 'kegiatan_ibadah.id_kategori_ibadah', '=', 'kategori_ibadah.id');
        if (!empty($request->nama_kegiatan_ibadah)) {
            $query->where(function($q) use ($request) {
                $q->where('kegiatan_ibadah.nama_kegiatan', 'like', '%' . $request->nama_kegiatan_ibadah . '%')
                  ->orWhere('kategori_ibadah.kategori_ibadah', 'like', '%' . $request->nama_kegiatan_ibadah . '%');
            });
        }
        $kegiatanibadah = $query->orderBy('kegiatan_ibadah.id', 'asc')->paginate(10);
        $kegiatanibadah->appends($request->all());
        return view('datamaster.kegiatanibadah.index', compact('kegiatanibadah'));
    }

    public function create()
    {
        $kategori_ibadah = Kategoriibadah::orderBy('kategori_ibadah', 'asc')->get();
        $data['kategori_ibadah'] = $kategori_ibadah;
        return view('datamaster.kegiatanibadah.create', $data);
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_kegiatan' => 'required',
            'id_kategori_ibadah' => 'required',
        ], [
            'nama_kegiatan.required' => 'Nama Kegiatan Ibadah wajib diisi',
            'id_kategori_ibadah.required' => 'Kategori Ibadah wajib dipilih',
        ]);

        try {
            $kegiatanibadah = new Kegiatanibadah();
            $kegiatanibadah->nama_kegiatan = $request->nama_kegiatan;
            $kegiatanibadah->id_kategori_ibadah = $request->id_kategori_ibadah;
            $kegiatanibadah->save();
            return Redirect::back()->with(messageSuccess('Kegiatan Ibadah Berhasil Ditambahkan'));
        } catch (\Exception $e) {
            return Redirect::back()->with(messageError('Kegiatan Ibadah Gagal Ditambahkan: ' . $e->getMessage()));
        }
    }

    public function edit($id)
    {
        $id = Crypt::decrypt($id);
        $kegiatanibadah = Kegiatanibadah::findOrFail($id);
        $kategori_ibadah = Kategoriibadah::orderBy('kategori_ibadah', 'asc')->get();
        $data['kategori_ibadah'] = $kategori_ibadah;
        $data['kegiatanibadah'] = $kegiatanibadah;
        return view('datamaster.kegiatanibadah.edit', $data);
    }

    public function update(Request $request, $id)
    {
        $id = Crypt::decrypt($id);
        $request->validate([
            'nama_kegiatan' => 'required',
            'id_kategori_ibadah' => 'required',
        ], [
            'nama_kegiatan.required' => 'Nama Kegiatan Ibadah wajib diisi',
            'id_kategori_ibadah.required' => 'Kategori Ibadah wajib dipilih',
        ]);

        try {
            $kegiatanibadah = Kegiatanibadah::findOrFail($id);
            $kegiatanibadah->nama_kegiatan = $request->nama_kegiatan;
            $kegiatanibadah->id_kategori_ibadah = $request->id_kategori_ibadah;
            $kegiatanibadah->save();
            return Redirect::back()->with(messageSuccess('Kegiatan Ibadah Berhasil Diubah'));
        } catch (\Exception $e) {
            return Redirect::back()->with(messageError('Kegiatan Ibadah Gagal Diubah: ' . $e->getMessage()));
        }
    }

    public function destroy($id)
    {
        $id = Crypt::decrypt($id);
        try {
            $kegiatanibadah = Kegiatanibadah::findOrFail($id);
            $kegiatanibadah->delete();
            return Redirect::back()->with(messageSuccess('Kegiatan Ibadah Berhasil Dihapus'));
        } catch (\Exception $e) {
            return Redirect::back()->with(messageError('Kegiatan Ibadah Gagal Dihapus: ' . $e->getMessage()));
        }
    }
}
