<?php

namespace App\Http\Controllers;

use App\Models\Anggota;
use App\Models\Jenissimpanan;
use App\Models\Karyawan;
use App\Models\Karyawananggota;
use App\Models\Saldosimpanan;
use App\Models\Simpanan;
use App\Models\User;
use App\Models\Userkaryawan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

class SimpananController extends Controller
{
    public function index(Request $request)
    {

        $subquerySaldosimpanan = Saldosimpanan::select('no_anggota', DB::raw('SUM(jumlah) as jml_saldo'))
            ->groupBy('no_anggota');
        $query = Anggota::query();
        $query->select('koperasi_anggota.*', 'jml_saldo');
        if (!empty($request->nama_lengkap)) {
            $query->where('nama_lengkap', 'like', "%" . $request->nama_lengkap . "%");
        }
        $query->leftJoinSub($subquerySaldosimpanan, 'saldosimpanan', 'koperasi_anggota.no_anggota', '=', 'saldosimpanan.no_anggota');
        $anggota = $query->paginate(10);
        $anggota->appends($request->all());
        $data['anggota'] = $anggota;
        return view('koperasi.simpanan.index', $data);
    }


    public function show($no_anggota, Request $request)
    {
        $user = User::where('id', auth()->user()->id)->first();
        $no_anggota = Crypt::decrypt($no_anggota);
        $data['anggota'] = Anggota::where('no_anggota', $no_anggota)
            ->leftJoin('provinces', 'koperasi_anggota.id_province', '=', 'provinces.id')
            ->leftJoin('regencies', 'koperasi_anggota.id_regency', '=', 'regencies.id')
            ->leftJoin('districts', 'koperasi_anggota.id_district', '=', 'districts.id')
            ->leftJoin('villages', 'koperasi_anggota.id_village', '=', 'villages.id')
            ->select('koperasi_anggota.*', 'provinces.name as province_name', 'regencies.name as regency_name', 'districts.name as district_name', 'villages.name as village_name')
            ->first();
        $data['saldo_simpanan'] = Saldosimpanan::where('no_anggota', $no_anggota)
            ->join('koperasi_jenis_simpanan', 'koperasi_saldo_simpanan.kode_simpanan', '=', 'koperasi_jenis_simpanan.kode_simpanan')
            ->get();

        $dari = date('Y-m-d', strtotime('-30 days'));
        $sampai = date('Y-m-d');

        $data['saldo_awal'] = $lastdata ? $lastdata->saldo : 0;
        $query = Simpanan::query();

        $query->select('koperasi_simpanan.*', 'jenis_simpanan', 'name');
        $query->join('koperasi_jenis_simpanan', 'koperasi_simpanan.kode_simpanan', '=', 'koperasi_jenis_simpanan.kode_simpanan');
        $query->leftJoin('users', 'koperasi_simpanan.id_petugas', '=', 'users.id');
        $query->where('no_anggota', $no_anggota);
        $query->orderBy('created_at', 'asc')->get();
        if (isset($request->dari) and isset($request->sampai)) {
            $query->whereBetween('tanggal', [$request->dari, $request->sampai]);
        } else {
            $query->whereBetween('tanggal', [$dari, $sampai]);
        }
        $transaksi_pertama = $query->first();
        $simpanan = $query->get();

        if (isset($request->dari) and isset($request->sampai)) {
            $lastdata = Simpanan::where('no_anggota', $no_anggota)
                ->where('tanggal', '<', $request->dari)
                ->orderBy('no_transaksi', 'desc')
                ->first();
        } else {
            $lastdata = Simpanan::where('no_anggota', $no_anggota)
                ->where('no_transaksi', '<', $transaksi_pertama->no_transaksi)
                ->orderBy('no_transaksi', 'desc')
                ->first();
        }

        $data['saldosimpanan'] = Saldosimpanan::where('no_anggota', $no_anggota)
            ->select('no_anggota', DB::raw('SUM(jumlah) as total_saldo'))
            ->groupBy('no_anggota')
            ->first();

        $data['lasttransaksi'] = Simpanan::where('no_anggota', $no_anggota)->orderBy('created_at', 'desc')->first();
        $data['simpanan'] = $simpanan;



        // if ($data['saldosimpanan'] == null) {
        //     return Redirect::back()->with(messageWarning('Anda Bukan Anggota Koperasi Tsarwah'));
        // }
        return view('koperasi.simpanan.show', $data);
    }

    public function showmobile($npp)
    {
        $npp = Crypt::decrypt($npp);
        $cekanggota = Karyawananggota::where('npp', $npp)->first();
        if ($cekanggota == null) {
            return Redirect::back()->with(messageWarning('Anda Belum Menjadi Anggota Koperasi Tsarwah'));
        } else {
            $no_anggota = $cekanggota->no_anggota;
        }

        $data['anggota'] = Anggota::where('no_anggota', $no_anggota)
            ->leftJoin('provinces', 'koperasi_anggota.id_province', '=', 'provinces.id')
            ->leftJoin('regencies', 'koperasi_anggota.id_regency', '=', 'regencies.id')
            ->leftJoin('districts', 'koperasi_anggota.id_district', '=', 'districts.id')
            ->leftJoin('villages', 'koperasi_anggota.id_village', '=', 'villages.id')
            ->select('koperasi_anggota.*', 'provinces.name as province_name', 'regencies.name as regency_name', 'districts.name as district_name', 'villages.name as village_name')
            ->first();
        $data['saldo_simpanan'] = Saldosimpanan::where('no_anggota', $no_anggota)
            ->join('koperasi_jenis_simpanan', 'koperasi_saldo_simpanan.kode_simpanan', '=', 'koperasi_jenis_simpanan.kode_simpanan')
            ->get();
        $data['saldosimpanan'] = Saldosimpanan::where('no_anggota', $no_anggota)
            ->select('no_anggota', DB::raw('SUM(jumlah) as total_saldo'))
            ->groupBy('no_anggota')
            ->first();
        $data['mutasi'] = Simpanan::where('no_anggota', $no_anggota)
            ->join('koperasi_jenis_simpanan', 'koperasi_simpanan.kode_simpanan', '=', 'koperasi_jenis_simpanan.kode_simpanan')
            ->orderBy('tanggal', 'desc')
            ->limit(5)
            ->get();

        $data['karyawan'] = Karyawananggota::join('karyawan', 'karyawan_anggota.npp', '=', 'karyawan.npp')
            ->join('jabatan', 'karyawan.kode_jabatan', '=', 'jabatan.kode_jabatan')
            ->join('unit', 'karyawan.kode_unit', '=', 'unit.kode_unit')
            ->where('karyawan_anggota.no_anggota', $no_anggota)->first();
        return view('koperasi.simpanan.show-mobile', $data);
    }


    public function create($no_anggota, $jenis_transaksi)
    {
        $data['no_anggota'] = Crypt::decrypt($no_anggota);
        $data['jenis_transaksi'] = $jenis_transaksi;
        $data['jenis_simpanan'] = Jenissimpanan::orderBy('kode_simpanan', 'asc')->get();
        return view('koperasi.simpanan.create', $data);
    }

    public function store($no_anggota, $jenis_transaksi, Request $request)
    {

        $request->validate([
            'tanggal' => 'required',
            'kode_simpanan' => 'required',
            'jumlah' => 'required',
            'berita' => 'required',
        ]);

        $no_anggota = Crypt::decrypt($no_anggota);
        $tanggal = $request->tanggal;
        $tgl = explode("-", $tanggal);
        $tahun = $tgl[0];
        $bulan = $tgl[1];
        if (strlen($bulan) > 1) {
            $bulan = $bulan;
        } else {
            $bulan = "0" . $bulan;
        }
        $format = "TS" . substr($tahun, 2, 2) . $bulan;


        //Cek Simpanan Terakhir
        $lastsimpanan = Simpanan::select('no_transaksi')
            ->where(DB::raw('left(no_transaksi,6)'), $format)
            ->orderBy('no_transaksi', 'desc')
            ->first();


        //Cek  No. Transaksi Terakir
        $last_no_transaksi = $lastsimpanan ? $lastsimpanan->no_transaksi : '';

        //Buat Kode Otomatsi No. Transaksi
        $no_transaksi = buatkode($last_no_transaksi, $format . "-", 4);

        //Cek Saldo Simpanan
        $saldo = Saldosimpanan::where('no_anggota', $no_anggota)->where('kode_simpanan', $request->kode_simpanan);
        $ceksaldo = $saldo->count();
        $datasaldo = $saldo->first();
        $jumlah = toNumber($request->jumlah);
        $operator = $jenis_transaksi == "S" ? "+" : "-";

        if ($datasaldo && $jenis_transaksi == 'T') {
            if ($datasaldo->jumlah < $jumlah && $jenis_transaksi == "T") {
                return Redirect::back()->with(messageError('Saldo  Tidak Mencukupi'));
            }
        }

        DB::beginTransaction();
        try {

            Simpanan::create([
                'no_transaksi' => $no_transaksi,
                'tanggal' => $tanggal,
                'no_anggota' => $no_anggota,
                'kode_simpanan' => $request->kode_simpanan,
                'jumlah' => $jumlah,
                'jenis_transaksi' => $jenis_transaksi,
                'berita' => $request->berita,
                'saldo' => 0,
                'id_petugas' => auth()->user()->id
            ]);

            if ($ceksaldo == 0) {
                Saldosimpanan::create([
                    'no_anggota' => $no_anggota,
                    'kode_simpanan' => $request->kode_simpanan,
                    'jumlah' => $jumlah
                ]);
            } else {
                Saldosimpanan::where('no_anggota', $no_anggota)
                    ->where('kode_simpanan', $request->kode_simpanan)
                    ->update([
                        'jumlah' => DB::raw('jumlah' . $operator . $jumlah)
                    ]);
            }

            //Cek Saldo Terakhir
            $ceksaldoterakhir = Saldosimpanan::select(DB::raw('SUM(jumlah) as jumlah'))
                ->where('no_anggota', $no_anggota)
                ->groupBy('no_anggota')
                ->first();

            //Update Saldo Transaksi
            Simpanan::where('no_transaksi', $no_transaksi)
                ->update([
                    'saldo' => $ceksaldoterakhir->jumlah
                ]);

            DB::commit();
            return Redirect::back()->with(messageSuccess('Data Berhasil Disimpan'));
        } catch (\Exception $e) {
            dd($e);
            DB::rollback();
            return Redirect::back()->with(messageError($e->getMessage()));
        }
    }


    public function destroy($no_transaksi)
    {

        $no_transaksi = Crypt::decrypt($no_transaksi);

        $cekanggota = Simpanan::where('no_transaksi', $no_transaksi)->first();
        $no_anggota = $cekanggota->no_anggota;
        $kode_simpanan = $cekanggota->kode_simpanan;
        $jenis_transaksi = $cekanggota->jenis_transaksi;
        $jumlah = $cekanggota->jumlah;
        $operator = $jenis_transaksi == "S" ? "-" : "+";

        DB::beginTransaction();
        try {

            Simpanan::where('no_transaksi', $no_transaksi)->delete();
            Saldosimpanan::where('no_anggota', $no_anggota)
                ->where('kode_simpanan', $kode_simpanan)
                ->update([
                    'jumlah' => DB::raw('jumlah' . $operator . $jumlah)
                ]);
            DB::commit();
            return Redirect::back()->with(messageSuccess('Data Berhasil Dihapus'));
        } catch (\Exception $e) {
            //dd($e);
            DB::rollback();
            return Redirect::back()->with(messageError($e->getMessage()));
        }
    }

    public function cetakkwitansi($no_transaksi)
    {
        $no_transaksi = Crypt::decrypt($no_transaksi);
        $data['transaksi'] = Simpanan::where('no_transaksi', $no_transaksi)
            ->join('koperasi_anggota', 'koperasi_simpanan.no_anggota', '=', 'koperasi_anggota.no_anggota')
            ->first();
        return view('koperasi.simpanan.cetakkwitansi', $data);
    }


    public function mutasi($kode_simpanan)
    {
        $user = User::where('id', auth()->user()->id)->first();
        $user_karyawan = Userkaryawan::where('id_user', $user->id)->first();
        $user_anggota = Karyawananggota::where('npp', $user_karyawan->npp)->first();
        $no_anggota = $user_anggota->no_anggota;
        $kode_simpanan = Crypt::decrypt($kode_simpanan);

        $dari = date('Y-m-d', strtotime('-30 days'));
        $sampai = date('Y-m-d');
        if (isset($request->dari) and isset($request->sampai)) {
            $lastdata = Simpanan::where('no_anggota', $no_anggota)
                ->where('kode_simpanan', $kode_simpanan)
                ->where('tanggal', '<', $request->dari)
                ->orderBy('no_transaksi', 'desc')
                ->first();
        } else {
            $lastdata = Simpanan::where('no_anggota', $no_anggota)
                ->where('tanggal', '<', $dari)
                ->where('kode_simpanan', $kode_simpanan)
                ->orderBy('no_transaksi', 'desc')
                ->first();
        }
        $data['saldo_awal'] = $lastdata ? $lastdata->saldo : 0;
        $data['saldo_simpanan'] = Saldosimpanan::where('no_anggota', $no_anggota)
            ->where('koperasi_saldo_simpanan.kode_simpanan', $kode_simpanan)
            ->join('koperasi_jenis_simpanan', 'koperasi_saldo_simpanan.kode_simpanan', '=', 'koperasi_jenis_simpanan.kode_simpanan')
            ->first();
        $data['mutasi'] = Simpanan::where('no_anggota', $no_anggota)
            ->where('koperasi_simpanan.kode_simpanan', $kode_simpanan)
            ->join('koperasi_jenis_simpanan', 'koperasi_simpanan.kode_simpanan', '=', 'koperasi_jenis_simpanan.kode_simpanan')
            ->orderBy('tanggal', 'desc')
            ->limit(15)
            ->get();
        return view('koperasi.simpanan.mutasi-mobile', $data);
    }
}
