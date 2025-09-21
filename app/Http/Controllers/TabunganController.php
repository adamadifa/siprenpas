<?php

namespace App\Http\Controllers;

use App\Models\Anggota;
use App\Models\Jenistabungan;
use App\Models\Karyawananggota;
use App\Models\Tabungan;
use App\Models\Transaksitabungan;
use App\Models\User;
use App\Models\Userkaryawan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Yajra\DataTables\DataTables;

class TabunganController extends Controller
{
    public function index(Request $request)
    {

        if ($request->ajax()) {
            $anggota = Anggota::select('*');
            return DataTables::of($anggota)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $btn = '<a href="javascript:void(0)" class="edit btn btn-primary btn-sm pilihAnggota" no_anggota="' . Crypt::encrypt($row->no_anggota) . '">Pilih</a>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make();
        }

        $query = Tabungan::query();
        $query->select('koperasi_tabungan.*', 'nama_lengkap', 'jenis_tabungan');
        $query->join('koperasi_anggota', 'koperasi_tabungan.no_anggota', '=', 'koperasi_anggota.no_anggota');
        $query->join('koperasi_jenis_tabungan', 'koperasi_tabungan.kode_tabungan', '=', 'koperasi_jenis_tabungan.kode_tabungan');
        if (!empty($request->nama_lengkap)) {
            $query->where('nama_lengkap', 'like', "%" . $request->nama_lengkap . "%");
        };

        if (!empty($request->kode_tabungan)) {
            $query->where('koperasi_tabungan.kode_tabungan', $request->kode_tabungan);
        }
        $query->orderBy('created_at', 'desc');
        $tabungan = $query->paginate(10);
        $tabungan->appends($request->all());
        $data['jenis_tabungan'] = Jenistabungan::all();
        $data['tabungan'] = $tabungan;
        return view('koperasi.tabungan.index', $data);
    }


    public function show($no_rekening, Request $request)
    {
        $no_rekening = Crypt::decrypt($no_rekening);
        $tabungan = Tabungan::where('no_rekening', $no_rekening)
            ->join('koperasi_jenis_tabungan', 'koperasi_tabungan.kode_tabungan', '=', 'koperasi_jenis_tabungan.kode_tabungan')
            ->first();

        $anggota = Anggota::where('no_anggota', $tabungan->no_anggota)
            ->leftJoin('provinces', 'koperasi_anggota.id_province', '=', 'provinces.id')
            ->leftJoin('regencies', 'koperasi_anggota.id_regency', '=', 'regencies.id')
            ->leftJoin('districts', 'koperasi_anggota.id_district', '=', 'districts.id')
            ->leftJoin('villages', 'koperasi_anggota.id_village', '=', 'villages.id')
            ->select('koperasi_anggota.*', 'provinces.name as province_name', 'regencies.name as regency_name', 'districts.name as district_name', 'villages.name as village_name')
            ->first();

        $dari = date('Y-m-d', strtotime('-60s days'));
        $sampai = date('Y-m-d');
        if (isset($request->dari) and isset($request->sampai)) {
            $lastdata = Transaksitabungan::where('no_rekening', $no_rekening)
                ->where('tanggal', '<', $request->dari)
                ->orderBy('no_transaksi', 'desc')
                ->first();
        } else {
            $lastdata = Transaksitabungan::where('no_rekening', $no_rekening)
                ->where('tanggal', '<', $dari)
                ->orderBy('no_transaksi', 'desc')
                ->first();
        }

        $query = Transaksitabungan::query();

        $query->select('koperasi_tabungan_transaksi.*', 'jenis_tabungan', 'name');
        $query->join('koperasi_tabungan', 'koperasi_tabungan_transaksi.no_rekening', '=', 'koperasi_tabungan.no_rekening');
        $query->join('koperasi_jenis_tabungan', 'koperasi_tabungan.kode_tabungan', '=', 'koperasi_jenis_tabungan.kode_tabungan');
        $query->leftJoin('users', 'koperasi_tabungan_transaksi.id_petugas', '=', 'users.id');
        $query->where('koperasi_tabungan_transaksi.no_rekening', $no_rekening);
        $query->orderBy('created_at', 'asc')->get();
        if (isset($request->dari) and isset($request->sampai)) {
            $query->whereBetween('tanggal', [$request->dari, $request->sampai]);
        } else {
            $query->whereBetween('tanggal', [$dari, $sampai]);
        }
        $transaksitabungan = $query->get();
        $data['lasttransaksi'] = Transaksitabungan::where('no_rekening', $no_rekening)->orderBy('created_at', 'desc')->first();
        $data['transaksitabungan'] = $transaksitabungan;
        $data['saldo_awal'] = $lastdata ? $lastdata->saldo : 0;

        $data['tabungan'] = $tabungan;
        $data['anggota'] = $anggota;
        return view('koperasi.tabungan.show', $data);
    }

    public function create($no_rekening, $jenis_transaksi)
    {
        $data['no_rekening'] = Crypt::decrypt($no_rekening);
        $data['jenis_transaksi'] = $jenis_transaksi;
        return view('koperasi.tabungan.create', $data);
    }


    public function store($no_rekening, $jenis_transaksi, Request $request)
    {

        $request->validate([
            'tanggal' => 'required',
            'jumlah' => 'required',
            'berita' => 'required',
        ]);

        $no_rekening = Crypt::decrypt($no_rekening);
        $tabungan = Tabungan::where('no_rekening', $no_rekening)->first();
        $tanggal = $request->tanggal;
        $tgl = explode("-", $tanggal);
        $tahun = $tgl[0];
        $bulan = $tgl[1];
        if (strlen($bulan) > 1) {
            $bulan = $bulan;
        } else {
            $bulan = "0" . $bulan;
        }


        $format = $tabungan->kode_tabungan . substr($tahun, 2, 2) . $bulan;


        //Cek Simpanan Terakhir
        $lastransaksi = Transaksitabungan::select('no_transaksi')
            ->where(DB::raw('left(no_transaksi,7)'), $format)
            ->orderBy('no_transaksi', 'desc')
            ->first();


        //Cek  No. Transaksi Terakir
        $last_no_transaksi = $lastransaksi ? $lastransaksi->no_transaksi : '';

        //Buat Kode Otomatsi No. Transaksi
        $no_transaksi = buatkode($last_no_transaksi, $format . "-", 3);

        //Cek Saldo Simpanan
        $saldo = Tabungan::where('no_rekening', $no_rekening);
        $ceksaldo = $saldo->count();
        $datasaldo = $saldo->first();
        $jumlah = toNumber($request->jumlah);
        $operator = $jenis_transaksi == "S" ? "+" : "-";

        if ($datasaldo && $jenis_transaksi == 'T') {
            if ($datasaldo->saldo < $jumlah && $jenis_transaksi == "T") {
                return Redirect::back()->with(messageError('Saldo  Tidak Mencukupi'));
            }
        }



        DB::beginTransaction();
        try {

            Transaksitabungan::create([
                'no_transaksi' => $no_transaksi,
                'tanggal' => $tanggal,
                'no_rekening' => $no_rekening,
                'jumlah' => $jumlah,
                'jenis_transaksi' => $jenis_transaksi,
                'berita' => $request->berita,
                'saldo' => 0,
                'id_petugas' => auth()->user()->id
            ]);

            Tabungan::where('no_rekening', $no_rekening)
                ->update([
                    'saldo' => DB::raw('saldo' . $operator . $jumlah)
                ]);

            //Cek Saldo Terakhir
            $ceksaldoterakhir = Tabungan::select('saldo')
                ->where('no_rekening', $no_rekening)
                ->first();



            //Update Saldo Transaksi
            Transaksitabungan::where('no_transaksi', $no_transaksi)
                ->update([
                    'saldo' => $ceksaldoterakhir->saldo
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

        $cekrekening = Transaksitabungan::where('no_transaksi', $no_transaksi)->first();
        $no_rekening = $cekrekening->no_rekening;
        $jenis_transaksi = $cekrekening->jenis_transaksi;
        $jumlah = $cekrekening->jumlah;
        $operator = $jenis_transaksi == "S" ? "-" : "+";

        DB::beginTransaction();
        try {

            Transaksitabungan::where('no_transaksi', $no_transaksi)->delete();
            Tabungan::where('no_rekening', $no_rekening)
                ->update([
                    'saldo' => DB::raw('saldo' . $operator . $jumlah)
                ]);
            DB::commit();
            return Redirect::back()->with(messageSuccess('Data Berhasil Dihapus'));
        } catch (\Exception $e) {
            //dd($e);
            DB::rollback();
            return Redirect::back()->with(messageError($e->getMessage()));
        }
    }

    public function createrekening(Request $request)
    {
        $data['jenis_tabungan'] = Jenistabungan::all();
        return view('koperasi.tabungan.createrekening', $data);
    }


    public function storerekening(Request $request)
    {

        $request->validate([
            'no_anggota' => 'required',
            'kode_tabungan' => 'required',
            'rfid' => 'nullable|string|max:20|unique:koperasi_tabungan,rfid',
        ]);

        $norek = $request->kode_tabungan . "-" . $request->no_anggota;
        $cek = DB::table('koperasi_tabungan')->where('no_rekening', $norek)->count();
        if ($cek > 0) {
            return Redirect::back()->with(messageError('Anggota Tersebut Sudah Memiliki No Rekening Untuk Tabungan ini'));
        } else {
            try {
                Tabungan::create([
                    'no_rekening' => $norek,
                    'kode_tabungan' => $request->kode_tabungan,
                    'no_anggota' => $request->no_anggota,
                    'saldo' => 0,
                    'rfid' => $request->rfid,
                    'id_petugas' => auth()->user()->id
                ]);
                return Redirect::back()->with(messageSuccess('Data Berhasil Disimpan'));
            } catch (\Exception $e) {
                return Redirect::back()->with(messageError($e->getMessage()));
            }
        }
    }

    public function deleterekening($no_rekening)
    {
        $no_rekening = Crypt::decrypt($no_rekening);
        try {
            Tabungan::where('no_rekening', $no_rekening)->delete();
            return Redirect::back()->with(messageSuccess('Data Berhasil Dihapus'));
        } catch (\Exception $e) {
            return Redirect::back()->with(messageError($e->getMessage()));
        }
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

        $data['saldotabungan'] = Tabungan::where('no_anggota', $no_anggota)
            ->select('no_anggota', DB::raw('SUM(saldo) as total_saldo'))
            ->groupBy('no_anggota')
            ->first();

        $data['saldo_tabungan'] = Tabungan::where('no_anggota', $no_anggota)
            ->join('koperasi_jenis_tabungan', 'koperasi_tabungan.kode_tabungan', '=', 'koperasi_jenis_tabungan.kode_tabungan')
            ->get();

        $data['karyawan'] = Karyawananggota::join('karyawan', 'karyawan_anggota.npp', '=', 'karyawan.npp')
            ->join('jabatan', 'karyawan.kode_jabatan', '=', 'jabatan.kode_jabatan')
            ->join('unit', 'karyawan.kode_unit', '=', 'unit.kode_unit')
            ->where('karyawan_anggota.no_anggota', $no_anggota)->first();

        $data['mutasi'] = Transaksitabungan::where('no_anggota', $no_anggota)
            ->join('koperasi_tabungan', 'koperasi_tabungan_transaksi.no_rekening', '=', 'koperasi_tabungan.no_rekening')
            ->join('koperasi_jenis_tabungan', 'koperasi_tabungan.kode_tabungan', '=', 'koperasi_jenis_tabungan.kode_tabungan')
            ->orderBy('tanggal', 'desc')
            ->limit(5)
            ->get();

        if ($data['saldotabungan'] == null) {
            return Redirect::back()->with(messageWarning('Anda Tidak memiliki Tabungan di Koperasi Tsarwah'));
        }

        return view('koperasi.tabungan.show-mobile', $data);
    }

    public function mutasi($no_rekening)
    {
        $user = User::where('id', auth()->user()->id)->first();
        $user_karyawan = Userkaryawan::where('id_user', $user->id)->first();
        $user_anggota = Karyawananggota::where('npp', $user_karyawan->npp)->first();
        $no_anggota = $user_anggota->no_anggota;
        $no_rekening = Crypt::decrypt($no_rekening);



        $data['saldo_tabungan'] = Tabungan::where('no_rekening', $no_rekening)
            ->join('koperasi_jenis_tabungan', 'koperasi_tabungan.kode_tabungan', '=', 'koperasi_jenis_tabungan.kode_tabungan')
            ->first();

        //dd($data['saldo_tabungan']);
        $data['mutasi'] = Transaksitabungan::where('no_anggota', $no_anggota)
            ->join('koperasi_tabungan', 'koperasi_tabungan_transaksi.no_rekening', '=', 'koperasi_tabungan.no_rekening')
            ->join('koperasi_jenis_tabungan', 'koperasi_tabungan.kode_tabungan', '=', 'koperasi_jenis_tabungan.kode_tabungan')
            ->orderBy('tanggal', 'desc')
            ->limit(15)
            ->get();
        return view('koperasi.tabungan.mutasi-mobile', $data);
    }

    public function edit($no_rekening)
    {
        $no_rekening = Crypt::decrypt($no_rekening);
        $tabungan = Tabungan::where('no_rekening', $no_rekening)
            ->join('koperasi_anggota', 'koperasi_tabungan.no_anggota', '=', 'koperasi_anggota.no_anggota')
            ->join('koperasi_jenis_tabungan', 'koperasi_tabungan.kode_tabungan', '=', 'koperasi_jenis_tabungan.kode_tabungan')
            ->select('koperasi_tabungan.*', 'koperasi_anggota.nama_lengkap', 'koperasi_jenis_tabungan.jenis_tabungan')
            ->first();
        
        if (!$tabungan) {
            return response()->json([
                'success' => false,
                'message' => 'Data tabungan tidak ditemukan'
            ], 404);
        }
        
        return response()->json([
            'success' => true,
            'data' => $tabungan
        ]);
    }

    public function update(Request $request, $no_rekening)
    {
        $no_rekening = Crypt::decrypt($no_rekening);
        
        $request->validate([
            'rfid' => 'nullable|string|max:20|unique:koperasi_tabungan,rfid,' . $no_rekening . ',no_rekening',
        ]);

        try {
            Tabungan::where('no_rekening', $no_rekening)
                ->update([
                    'rfid' => $request->rfid
                ]);
            
            return response()->json([
                'success' => true,
                'message' => 'Data RFID berhasil diperbarui'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
