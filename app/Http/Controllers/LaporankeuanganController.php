<?php

namespace App\Http\Controllers;

use App\Models\Biayasiswa;
use App\Models\Detailhistoribayarpendidikan;
use App\Models\Pendaftaran;
use App\Models\Tahunajaran;
use App\Models\Unit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LaporankeuanganController extends Controller
{
    public function index()
    {
        $u = new Unit();
        $data['unit'] = $u->getUnit();

        $data['tahun_ajaran'] = Tahunajaran::where('status', 1)->first();
        $data['tahunajaran'] = Tahunajaran::orderBy('kode_ta')->get();
        return view('keuangan.laporan.index', $data);
    }


    public function cetakrekaptagihan(Request $request)
    {



        $biaya = Biayasiswa::join('konfigurasi_biaya_detail', 'siswa_biaya.kode_biaya', '=', 'konfigurasi_biaya_detail.kode_biaya')
            ->join('jenis_biaya', 'konfigurasi_biaya_detail.kode_jenis_biaya', '=', 'jenis_biaya.kode_jenis_biaya')
            ->join('pendaftaran', 'siswa_biaya.no_pendaftaran', '=', 'pendaftaran.no_pendaftaran')
            ->join('konfigurasi_biaya', 'siswa_biaya.kode_biaya', 'konfigurasi_biaya.kode_biaya')
            ->select('konfigurasi_biaya_detail.kode_jenis_biaya', 'jenis_biaya')
            ->where('pendaftaran.kode_ta', $request->kode_ta)
            ->where('konfigurasi_biaya.tingkat', $request->tingkat)
            ->where('pendaftaran.kode_unit', $request->kode_unit)
            ->orderBy('konfigurasi_biaya_detail.kode_jenis_biaya')
            ->groupBy('konfigurasi_biaya_detail.kode_jenis_biaya', 'jenis_biaya')
            ->get();

        $historibayar = Detailhistoribayarpendidikan::join('pendidikan_historibayar', 'pendidikan_historibayar_detail.no_bukti', '=', 'pendidikan_historibayar.no_bukti')
            ->select(
                'no_pendaftaran',
                'kode_biaya',
                'kode_jenis_biaya',
                DB::raw('SUM(jumlah) as jmlbayar')
            )
            ->groupBy('no_pendaftaran', 'kode_biaya', 'kode_jenis_biaya');
        $select_tagihan = [];
        $select_potongan = [];
        $select_mutasi = [];
        $select_bayar = [];
        //$select_field_tagihan = [];
        foreach ($biaya as $b) {
            $select_tagihan[] = DB::raw('SUM(IF(konfigurasi_biaya_detail.kode_jenis_biaya = "' . $b->kode_jenis_biaya . '", konfigurasi_biaya_detail.jumlah, 0)) as jumlah_' . $b->kode_jenis_biaya);
            $select_potongan[] = DB::raw('SUM(IF(konfigurasi_biaya_detail.kode_jenis_biaya = "' . $b->kode_jenis_biaya . '", pendaftaran_potongan.jumlah, 0)) as jumlah_potongan_' . $b->kode_jenis_biaya);
            $select_mutasi[] = DB::raw('SUM(IF(konfigurasi_biaya_detail.kode_jenis_biaya = "' . $b->kode_jenis_biaya . '", pembayaran_pendidikan_mutasi.jumlah, 0)) as jumlah_mutasi_' . $b->kode_jenis_biaya);
            $select_bayar[] = DB::raw('SUM(IF(konfigurasi_biaya_detail.kode_jenis_biaya = "' . $b->kode_jenis_biaya . '", historibayar.jmlbayar, 0)) as jumlah_bayar_' . $b->kode_jenis_biaya);
            // $select_field_tagihan[] = "jumlah_" . $b->kode_jenis_biaya;
        }
        $qrekaptagihan = Biayasiswa::query();
        $qrekaptagihan->select(
            'pendaftaran.nis',
            'siswa.nama_lengkap',
            ...$select_tagihan,
            ...$select_potongan,
            ...$select_mutasi,
            ...$select_bayar
        );
        $qrekaptagihan->orderBy('nama_lengkap');
        $qrekaptagihan->join('konfigurasi_biaya_detail', 'siswa_biaya.kode_biaya', '=', 'konfigurasi_biaya_detail.kode_biaya');
        $qrekaptagihan->join('pendaftaran', 'siswa_biaya.no_pendaftaran', '=', 'pendaftaran.no_pendaftaran');
        $qrekaptagihan->join('siswa', 'pendaftaran.id_siswa', '=', 'siswa.id_siswa');
        $qrekaptagihan->join('konfigurasi_biaya', 'siswa_biaya.kode_biaya', '=', 'konfigurasi_biaya.kode_biaya');
        $qrekaptagihan->leftJoin('pendaftaran_potongan', function ($join) {
            $join->on('pendaftaran_potongan.kode_biaya', '=', 'konfigurasi_biaya.kode_biaya')
                ->on('pendaftaran_potongan.kode_jenis_biaya', '=', 'konfigurasi_biaya_detail.kode_jenis_biaya')
                ->on('pendaftaran_potongan.no_pendaftaran', '=', 'siswa_biaya.no_pendaftaran');
        });

        $qrekaptagihan->leftJoin('pembayaran_pendidikan_mutasi', function ($join) {
            $join->on('pembayaran_pendidikan_mutasi.kode_biaya', '=', 'konfigurasi_biaya.kode_biaya')
                ->on('pembayaran_pendidikan_mutasi.kode_jenis_biaya', '=', 'konfigurasi_biaya_detail.kode_jenis_biaya')
                ->on('pembayaran_pendidikan_mutasi.no_pendaftaran', '=', 'siswa_biaya.no_pendaftaran');
        });

        $qrekaptagihan->leftJoinSub($historibayar, 'historibayar', function ($join) {
            $join->on('historibayar.no_pendaftaran', '=', 'siswa_biaya.no_pendaftaran')
                ->on('historibayar.kode_biaya', '=', 'konfigurasi_biaya.kode_biaya')
                ->on('historibayar.kode_jenis_biaya', '=', 'konfigurasi_biaya_detail.kode_jenis_biaya');
        });
        $qrekaptagihan->where('pendaftaran.kode_unit', $request->kode_unit);
        $qrekaptagihan->where('pendaftaran.kode_ta', $request->kode_ta);
        $qrekaptagihan->where('konfigurasi_biaya.tingkat', $request->tingkat);
        $qrekaptagihan->groupBy('pendaftaran.nis', 'siswa.nama_lengkap');
        $data['rekaptagihan'] = $qrekaptagihan->get();
        $data['biaya'] = $biaya;

        return view('keuangan.laporan.rekaptagihan_cetak', $data);
    }
}
