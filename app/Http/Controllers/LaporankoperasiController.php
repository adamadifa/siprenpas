<?php

namespace App\Http\Controllers;

use App\Models\Jenissimpanan;
use App\Models\Jenistabungan;
use App\Models\Simpanan;
use App\Models\Tabungan;
use App\Models\Transaksitabungan;
use Illuminate\Http\Request;

class LaporankoperasiController extends Controller
{
    public function index()
    {
        $data['jenis_simpanan'] = Jenissimpanan::orderBy('kode_simpanan', 'asc')->get();
        $data['jenis_tabungan'] = Jenistabungan::orderBy('kode_tabungan', 'asc')->get();
        return view('koperasi.laporan.index', $data);
    }


    public function cetaksimpanan(Request $request)
    {
        $request->validate([
            'dari' => 'required',
            'sampai' => 'required',
        ]);
        $jenis_simpanan = Jenissimpanan::where('kode_simpanan', $request->kode_simpanan)->first();
        $query = Simpanan::query();
        $query->select('koperasi_simpanan.*', 'nama_lengkap', 'jenis_simpanan', 'name');
        $query->join('koperasi_anggota', 'koperasi_simpanan.no_anggota', '=', 'koperasi_anggota.no_anggota');
        $query->join('koperasi_jenis_simpanan', 'koperasi_simpanan.kode_simpanan', '=', 'koperasi_jenis_simpanan.kode_simpanan');
        $query->leftJoin('users', 'koperasi_simpanan.id_petugas', '=', 'users.id');
        if (!empty($request->kode_simpanan)) {
            $query->where('koperasi_simpanan.kode_simpanan', $request->kode_simpanan);
        }
        $query->whereBetween('tanggal', [$request->dari, $request->sampai])->get();
        $data['simpanan'] = $query->get();
        $data['dari'] = $request->dari;
        $data['sampai'] = $request->sampai;
        $data['jenis_simpanan'] = $jenis_simpanan;
        return view('koperasi.laporan.simpanan_cetak', $data);
    }


    public function cetaktabungan(Request $request)
    {
        $request->validate([
            'dari' => 'required',
            'sampai' => 'required',
        ]);
        $jenis_tabungan = Jenistabungan::where('kode_tabungan', $request->kode_tabungan)->first();
        $query = Transaksitabungan::query();
        $query->select('koperasi_tabungan_transaksi.*', 'koperasi_tabungan.no_anggota', 'nama_lengkap', 'jenis_tabungan', 'name');
        $query->join('koperasi_tabungan', 'koperasi_tabungan_transaksi.no_rekening', '=', 'koperasi_tabungan.no_rekening');
        $query->join('koperasi_anggota', 'koperasi_tabungan.no_anggota', '=', 'koperasi_anggota.no_anggota');
        $query->join('koperasi_jenis_tabungan', 'koperasi_tabungan.kode_tabungan', '=', 'koperasi_jenis_tabungan.kode_tabungan');
        $query->leftJoin('users', 'koperasi_tabungan_transaksi.id_petugas', '=', 'users.id');
        if (!empty($request->kode_tabungan)) {
            $query->where('koperasi_tabungan.kode_tabungan', $request->kode_tabungan);
        }
        $query->whereBetween('tanggal', [$request->dari, $request->sampai])->get();
        $data['simpanan'] = $query->get();
        $data['dari'] = $request->dari;
        $data['sampai'] = $request->sampai;
        $data['jenis_tabungan'] = $jenis_tabungan;
        return view('koperasi.laporan.tabungan_cetak', $data);
    }
}
