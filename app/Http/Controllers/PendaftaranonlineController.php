<?php

namespace App\Http\Controllers;

use App\Models\Pembayaranpendaftaranonline;
use App\Models\Pendaftaran;
use App\Models\Pendaftaranonline;
use App\Models\Tahunajaran;
use App\Models\Unit;
use Barryvdh\DomPDF\Facade\Pdf as FacadePdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Barryvdh\DomPDF\Facades\Pdf;

class PendaftaranonlineController extends Controller
{
    public function index(Request $request)
    {


        $tahunajaran = Tahunajaran::where('status', 1)->first();
        $kode_ta = $tahunajaran->kode_ta;

        $qpendaftaran = Pendaftaranonline::query();
        $qpendaftaran->select(
            'pendaftaran_online.*',
            'pendaftaran_online_bayar.id as id_bayar',
            'pendaftaran_online_bayar.status as status_bayar',
            'unit.nama_unit as nama_unit',
            'konfigurasi_tahun_ajaran.tahun_ajaran as tahun_ajaran'
        );
        $qpendaftaran->join('unit', 'unit.kode_unit', 'pendaftaran_online.kode_unit');
        $qpendaftaran->join('konfigurasi_tahun_ajaran', 'konfigurasi_tahun_ajaran.kode_ta', 'pendaftaran_online.kode_ta');
        $qpendaftaran->leftJoin('pendaftaran_online_bayar', 'pendaftaran_online_bayar.no_register', 'pendaftaran_online.no_register');
        $qpendaftaran->orderBy('no_register', 'desc');
        $qpendaftaran->where('pendaftaran_online.kode_ta', $kode_ta);
        $pendaftaran = $qpendaftaran->get();
        $data['pendaftaran'] = $pendaftaran;
        $data['unit'] = Unit::orderBy('kode_unit')->get();
        $data['jenis_kelamin'] = config('global.jenis_kelamin');
        $data['tahunajaran'] = Tahunajaran::orderBy('kode_ta')->get();

        return view('pendaftaranonline.index', $data);
    }

    public function show($no_register)
    {
        $no_register = Crypt::decrypt($no_register);
        $data['pendaftaran'] = Pendaftaranonline::where('no_register', $no_register)
            ->join('unit', 'unit.kode_unit', 'pendaftaran_online.kode_unit')
            ->join('konfigurasi_tahun_ajaran', 'konfigurasi_tahun_ajaran.kode_ta', 'pendaftaran_online.kode_ta')
            ->first();
        $data['pembayaran'] = Pembayaranpendaftaranonline::where('no_register', $no_register)->first();
        return view('pendaftaranonline.show', $data);
    }

    public function cetak($no_register)
    {
        $no_register = Crypt::decrypt($no_register);
        $pendaftaran = Pendaftaranonline::where('no_register', $no_register)
            ->join('unit', 'unit.kode_unit', 'pendaftaran_online.kode_unit')
            ->join('konfigurasi_tahun_ajaran', 'konfigurasi_tahun_ajaran.kode_ta', 'pendaftaran_online.kode_ta')
            ->first();
        $pdf = FacadePdf::loadView('pendaftaranonline.cetak', compact('pendaftaran'));
        return $pdf->stream('formulir-pendaftaran-online.pdf');
    }
}
