<?php

namespace App\Http\Controllers;

use App\Models\Biaya;
use App\Models\Biayasiswa;
use App\Models\Detailbiaya;
use App\Models\Detailhistoribayarpendidikan;
use App\Models\Detailrencanaspp;
use App\Models\Historibayarpendidikan;
use App\Models\Mutasipembayaranpendidikan;
use App\Models\Pendaftaran;
use App\Models\Potonganpendaftaran;
use App\Models\Siswa;
use App\Models\Tahunajaran;
use App\Models\Unit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class PembayaranpendidikanController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $siswa = Siswa::select('*');
            return DataTables::of($siswa)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $btn = '<a href="javascript:void(0)" class="edit btn btn-primary btn-sm pilihsiswa" id_siswa="' . Crypt::encrypt($row->id_siswa) . '">Pilih</a>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make();
        }
        $data['tahun_ajaran'] = Tahunajaran::where('status', 1)->first();

        $p = new Pendaftaran();
        $pendaftaran = $p->getPembayaranpendidikan(request: $request)->paginate(30);
        $pendaftaran->appends($request->all());
        $data['pendaftaran'] = $pendaftaran;
        $u = new Unit();
        $data['unit'] = $u->getUnit();
        $data['jenis_kelamin'] = config('global.jenis_kelamin');
        $data['tahunajaran'] = Tahunajaran::orderBy('kode_ta')->get();

        return view('pembayaranpendidikan.index', $data);
    }

    public function show($no_pendaftaran)
    {
        $no_pendaftaran = Crypt::decrypt($no_pendaftaran);
        $mpendaftaran = new Pendaftaran();
        $pendaftaran = $mpendaftaran->getPendaftaran($no_pendaftaran)->first();


        $data['pendaftaran'] = $pendaftaran;
        return view('pembayaranpendidikan.show', $data);
    }


    public function getbiaya($no_pendaftaran)
    {
        $no_pendaftaran = Crypt::decrypt($no_pendaftaran);
        $mpendaftaran = new Pendaftaran();
        $pendaftaran = $mpendaftaran->getPendaftaran($no_pendaftaran)->first();

        // $qpotongan = Potonganpendaftaran::where('no_pendaftaran', $no_pendaftaran)
        //     ->where('kode_biaya', $pendaftaran->kode_biaya);


        // $qmutasi = Mutasipembayaranpendidikan::where('no_pendaftaran', $no_pendaftaran)
        //     ->where('kode_biaya', $pendaftaran->kode_biaya);


        // $biaya = Detailbiaya::where('konfigurasi_biaya_detail.kode_biaya', $pendaftaran->kode_biaya)
        //     ->select(
        //         'konfigurasi_biaya_detail.*',
        //         'potongan.jumlah as jumlah_potongan',
        //         'mutasi.jumlah as jumlah_mutasi',
        //         'jenis_biaya',
        //     )
        //     ->join('konfigurasi_biaya', 'konfigurasi_biaya.kode_biaya', '=', 'konfigurasi_biaya_detail.kode_biaya')
        //     ->join('jenis_biaya', 'jenis_biaya.kode_jenis_biaya', '=', 'konfigurasi_biaya_detail.kode_jenis_biaya')
        //     ->leftjoinSub($qpotongan, 'potongan', function ($join) {
        //         $join->on('konfigurasi_biaya_detail.kode_jenis_biaya', '=', 'potongan.kode_jenis_biaya');
        //     })
        //     ->leftjoinSub($qmutasi, 'mutasi', function ($join) {
        //         $join->on('konfigurasi_biaya_detail.kode_jenis_biaya', '=', 'mutasi.kode_jenis_biaya');
        //     })
        //     ->orderBy('konfigurasi_biaya_detail.kode_jenis_biaya')
        //     ->get();

        $historibayar = Detailhistoribayarpendidikan::where('no_pendaftaran', $no_pendaftaran)
            ->join('pendidikan_historibayar', 'pendidikan_historibayar_detail.no_bukti', '=', 'pendidikan_historibayar.no_bukti')
            ->select(
                'no_pendaftaran',
                'kode_biaya',
                'kode_jenis_biaya',
                DB::raw('SUM(jumlah) as jmlbayar')
            )
            ->groupBy('no_pendaftaran', 'kode_biaya', 'kode_jenis_biaya');
        $biaya = Biayasiswa::where('siswa_biaya.no_pendaftaran', $no_pendaftaran)
            ->select(
                'konfigurasi_biaya_detail.*',
                'pendaftaran_potongan.jumlah as jumlah_potongan',
                'pembayaran_pendidikan_mutasi.jumlah as jumlah_mutasi',
                'jenis_biaya',
                'jmlbayar',
                'tahun_ajaran'
            )
            ->join('konfigurasi_biaya', 'konfigurasi_biaya.kode_biaya', '=', 'siswa_biaya.kode_biaya')
            ->join('konfigurasi_biaya_detail', 'konfigurasi_biaya_detail.kode_biaya', '=', 'konfigurasi_biaya.kode_biaya')
            ->join('jenis_biaya', 'jenis_biaya.kode_jenis_biaya', '=', 'konfigurasi_biaya_detail.kode_jenis_biaya')
            ->join('konfigurasi_tahun_ajaran', 'konfigurasi_tahun_ajaran.kode_ta', '=', 'konfigurasi_biaya.kode_ta')
            ->leftJoin('pendaftaran_potongan', function ($join) {
                $join->on('pendaftaran_potongan.kode_biaya', '=', 'konfigurasi_biaya.kode_biaya')
                    ->on('pendaftaran_potongan.kode_jenis_biaya', '=', 'konfigurasi_biaya_detail.kode_jenis_biaya')
                    ->on('pendaftaran_potongan.no_pendaftaran', '=', 'siswa_biaya.no_pendaftaran');
            })
            ->leftJoin('pembayaran_pendidikan_mutasi', function ($join) {
                $join->on('pembayaran_pendidikan_mutasi.kode_biaya', '=', 'konfigurasi_biaya.kode_biaya')
                    ->on('pembayaran_pendidikan_mutasi.kode_jenis_biaya', '=', 'konfigurasi_biaya_detail.kode_jenis_biaya')
                    ->on('pembayaran_pendidikan_mutasi.no_pendaftaran', '=', 'siswa_biaya.no_pendaftaran');
            })
            ->leftJoinSub($historibayar, 'historibayar', function ($join) {
                $join->on('historibayar.no_pendaftaran', '=', 'siswa_biaya.no_pendaftaran')
                    ->on('historibayar.kode_biaya', '=', 'konfigurasi_biaya.kode_biaya')
                    ->on('historibayar.kode_jenis_biaya', '=', 'konfigurasi_biaya_detail.kode_jenis_biaya');
            })
            ->orderBy('konfigurasi_biaya.kode_biaya', 'asc')
            ->orderBy('konfigurasi_biaya_detail.kode_jenis_biaya', 'asc')
            ->get();

        $data['biaya'] = $biaya;
        $data['pendaftaran'] = $pendaftaran;

        return view('pembayaranpendidikan.getbiaya', $data);
    }


    public function createpotongan($no_pendaftaran, $kode_jenis_biaya, $kode_biaya)
    {

        $no_pendaftaran = Crypt::decrypt($no_pendaftaran);
        $kode_jenis_biaya = Crypt::decrypt($kode_jenis_biaya);
        $kode_biaya = Crypt::decrypt($kode_biaya);
        $data['no_pendaftaran'] = $no_pendaftaran;
        $data['kode_jenis_biaya'] = $kode_jenis_biaya;
        $data['kode_biaya'] = $kode_biaya;
        $potongan = Potonganpendaftaran::where('no_pendaftaran', $no_pendaftaran)
            ->where('kode_jenis_biaya', $kode_jenis_biaya)
            ->where('kode_biaya', $kode_biaya)
            ->first();
        $data['potongan'] = $potongan;
        return view('pembayaranpendidikan.createpotongan', $data);
    }

    public function storepotongan(Request $request)
    {
        $detailbiaya = Detailbiaya::where('kode_biaya', $request->kode_biaya)->where('kode_jenis_biaya', $request->kode_jenis_biaya)->first();

        $request->validate([
            'potongan' => [
                'required',
                'regex:/^\d{1,3}(\.\d{3})*$/', // Memastikan format angka dengan titik sebagai pemisah ribuan
                function ($attribute, $value, $fail) use ($detailbiaya) {
                    // Hapus titik agar menjadi angka yang bisa di-cast ke integer atau float
                    $unformatted = str_replace('.', '', $value);

                    // Cek apakah hasilnya adalah angka dan tidak melebihi 50.000
                    if (!is_numeric($unformatted)) {
                        $fail('Nilai ' . $attribute . ' harus berupa angka yang valid ');
                    } else if ($unformatted > $detailbiaya->jumlah) {
                        $fail('Nilai ' . $attribute . ' tidak boleh lebih dari ' . formatAngka($detailbiaya->jumlah) . '.');
                    }
                },
            ],
            'keterangan' => 'required',
        ]);

        $kode_potongan = $request->no_pendaftaran . $request->kode_biaya . $request->kode_jenis_biaya;
        $cek = Potonganpendaftaran::where('kode_potongan', $kode_potongan)->first();
        try {
            if ($cek) {
                Potonganpendaftaran::where('kode_potongan', $kode_potongan)->update([
                    'jumlah' => toNumber($request->potongan),
                    'keterangan' => $request->keterangan,
                ]);
            } else {
                Potonganpendaftaran::create([
                    'kode_potongan' => $kode_potongan,
                    'no_pendaftaran' => $request->no_pendaftaran,
                    'kode_biaya' => $request->kode_biaya,
                    'kode_jenis_biaya' => $request->kode_jenis_biaya,
                    'jumlah' => toNumber($request->potongan),
                    'keterangan' => $request->keterangan,
                ]);
            }

            return response()->json(['success' => true, 'message' => 'Potongan berhasil ditambahkan', 'no_pendaftaran' => Crypt::encrypt($request->no_pendaftaran)], 200);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Potongan gagal ditambahkan ' . $e->getMessage()], 500);
        }
    }


    public function createmutasi($no_pendaftaran, $kode_jenis_biaya, $kode_biaya)
    {

        $no_pendaftaran = Crypt::decrypt($no_pendaftaran);
        $kode_jenis_biaya = Crypt::decrypt($kode_jenis_biaya);
        $kode_biaya = Crypt::decrypt($kode_biaya);
        $data['no_pendaftaran'] = $no_pendaftaran;
        $data['kode_jenis_biaya'] = $kode_jenis_biaya;
        $data['kode_biaya'] = $kode_biaya;
        $mutasi = Mutasipembayaranpendidikan::where('no_pendaftaran', $no_pendaftaran)
            ->where('kode_biaya', $kode_biaya)
            ->where('kode_jenis_biaya', $kode_jenis_biaya)
            ->first();
        $data['mutasi'] = $mutasi;
        return view('pembayaranpendidikan.createmutasi', $data);
    }


    public function storemutasi(Request $request)
    {
        $detailbiaya = Detailbiaya::where('kode_biaya', $request->kode_biaya)->where('kode_jenis_biaya', $request->kode_jenis_biaya)->first();

        $request->validate([
            'jumlah' => [
                'required',
                'regex:/^\d{1,3}(\.\d{3})*$/', // Memastikan format angka dengan titik sebagai pemisah ribuan
                function ($attribute, $value, $fail) use ($detailbiaya) {
                    // Hapus titik agar menjadi angka yang bisa di-cast ke integer atau float
                    $unformatted = str_replace('.', '', $value);

                    // Cek apakah hasilnya adalah angka dan tidak melebihi 50.000
                    if (!is_numeric($unformatted)) {
                        $fail('Nilai ' . $attribute . ' harus berupa angka yang valid ');
                    } else if ($unformatted > $detailbiaya->jumlah) {
                        $fail('Nilai ' . $attribute . ' tidak boleh lebih dari ' . formatAngka($detailbiaya->jumlah) . '.');
                    }
                },
            ],
            'keterangan' => 'required',
        ]);

        $kode_mutasi     = $request->no_pendaftaran . $request->kode_biaya . $request->kode_jenis_biaya;
        $cek = Mutasipembayaranpendidikan::where('kode_mutasi', $kode_mutasi)->first();
        try {
            if ($cek) {
                Mutasipembayaranpendidikan::where('kode_mutasi', $kode_mutasi)->update([
                    'jumlah' => toNumber($request->jumlah),
                    'keterangan' => $request->keterangan,
                ]);
            } else {
                Mutasipembayaranpendidikan::create([
                    'kode_mutasi' => $kode_mutasi,
                    'no_pendaftaran' => $request->no_pendaftaran,
                    'kode_biaya' => $request->kode_biaya,
                    'kode_jenis_biaya' => $request->kode_jenis_biaya,
                    'jumlah' => toNumber($request->jumlah),
                    'keterangan' => $request->keterangan,
                ]);
            }

            return response()->json(['success' => true, 'message' => 'Mutasi berhasil ditambahkan', 'no_pendaftaran' => Crypt::encrypt($request->no_pendaftaran)], 200);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Mutasi gagal ditambahkan ' . $e->getMessage()], 500);
        }
    }

    public function create($no_pendaftaran)
    {
        $no_pendaftaran = Crypt::decrypt($no_pendaftaran);
        $biaya = Biayasiswa::where('siswa_biaya.no_pendaftaran', $no_pendaftaran)
            ->select(
                'konfigurasi_biaya_detail.*',
                'pendaftaran_potongan.jumlah as jumlah_potongan',
                'pembayaran_pendidikan_mutasi.jumlah as jumlah_mutasi',
                'jenis_biaya',
                'tahun_ajaran'
            )
            ->join('konfigurasi_biaya', 'konfigurasi_biaya.kode_biaya', '=', 'siswa_biaya.kode_biaya')
            ->join('konfigurasi_biaya_detail', 'konfigurasi_biaya_detail.kode_biaya', '=', 'konfigurasi_biaya.kode_biaya')
            ->join('jenis_biaya', 'jenis_biaya.kode_jenis_biaya', '=', 'konfigurasi_biaya_detail.kode_jenis_biaya')
            ->join('konfigurasi_tahun_ajaran', 'konfigurasi_tahun_ajaran.kode_ta', '=', 'konfigurasi_biaya.kode_ta')
            ->leftJoin('pendaftaran_potongan', function ($join) {
                $join->on('pendaftaran_potongan.kode_biaya', '=', 'konfigurasi_biaya.kode_biaya')
                    ->on('pendaftaran_potongan.kode_jenis_biaya', '=', 'konfigurasi_biaya_detail.kode_jenis_biaya')
                    ->on('pendaftaran_potongan.no_pendaftaran', '=', 'siswa_biaya.no_pendaftaran');
            })
            ->leftJoin('pembayaran_pendidikan_mutasi', function ($join) {
                $join->on('pembayaran_pendidikan_mutasi.kode_biaya', '=', 'konfigurasi_biaya.kode_biaya')
                    ->on('pembayaran_pendidikan_mutasi.kode_jenis_biaya', '=', 'konfigurasi_biaya_detail.kode_jenis_biaya')
                    ->on('pembayaran_pendidikan_mutasi.no_pendaftaran', '=', 'siswa_biaya.no_pendaftaran');
            })
            ->orderBy('konfigurasi_biaya.kode_biaya', 'asc')
            ->orderBy('konfigurasi_biaya_detail.kode_jenis_biaya', 'asc')
            ->get();
        $data['biaya'] = $biaya;
        $data['no_pendaftaran'] = $no_pendaftaran;
        return view('pembayaranpendidikan.create', $data);
    }


    public function store(Request $request)
    {
        $no_pendaftaran = Crypt::decrypt($request->no_pendaftaran);
        $tahun = date('Y', strtotime($request->tanggal));
        $bulan = date('m', strtotime($request->tanggal));
        $kode_biaya = $request->kode_biaya;
        $kode_jenis_biaya = $request->kode_jenis_biaya;
        $jumlah = $request->jumlah;
        $keterangan = $request->keterangan;
        $cicilan = "";
        $listbln = "";
        $nama_bulan = [
            '',
            'Januari',
            'Februari',
            'Maret',
            'April',
            'Mei',
            'Juni',
            'Juli',
            'Agustus',
            'September',
            'Oktober',
            'November',
            'Desember'
        ];
        DB::beginTransaction();
        try {
            $lastpembayaran = Historibayarpendidikan::select('no_bukti')
                ->whereRaw('MONTH(tanggal) = ' . $bulan . ' AND YEAR(tanggal) = ' . $tahun)
                ->orderBy('no_bukti', 'desc')
                ->first();
            $last_no_bukti = $lastpembayaran ? $lastpembayaran->no_bukti : '';
            $no_bukti = buatkode($last_no_bukti, substr($tahun, 2, 2) . $bulan, 5);
            Historibayarpendidikan::create([
                'no_bukti' => $no_bukti,
                'tanggal' => $request->tanggal,
                'no_pendaftaran' => $no_pendaftaran,
                'id_user' => Auth::user()->id,
            ]);
            for ($i = 0; $i < count($kode_biaya); $i++) {
                if ($kode_jenis_biaya[$i] == 'B07') {
                    // Ambil semua rencana spp yang belum lunas, urutkan dari bulan terawal
                    $rencana = Detailrencanaspp::join('spp_rencana', 'spp_rencana_detail.kode_rencana_spp', '=', 'spp_rencana.kode_rencana_spp')
                        ->where('no_pendaftaran', $no_pendaftaran)
                        ->where('kode_biaya', $kode_biaya[$i])
                        ->whereRaw('jumlah != realisasi')
                        ->orderBy('tahun', 'asc')
                        ->orderBy('bulan', 'asc')
                        ->select('spp_rencana_detail.*', 'spp_rencana.kode_rencana_spp')
                        ->get();

                    $sisa = toNumber($jumlah[$i]);
                    $cicilan = "";
                    $listbln = "";

                    foreach ($rencana as $d) {
                        $sisapercicilan = $d->jumlah - $d->realisasi;
                        if ($sisapercicilan <= 0) {
                            continue;
                        }

                        if ($sisa <= 0) {
                            break;
                        }

                        $bayar = min($sisa, $sisapercicilan);

                        // Update realisasi
                        Detailrencanaspp::where('kode_rencana_spp', $d->kode_rencana_spp)
                            ->where('cicilan_ke', $d->cicilan_ke)
                            ->update([
                                'realisasi' => DB::raw('realisasi + ' . $bayar)
                            ]);

                        // Penanda pelunasan atau sebagian
                        if ($bayar == $sisapercicilan) {
                            // Lunas
                            $keterangan_bln = $nama_bulan[$d->bulan];
                            if ($d->realisasi > 0) {
                                // Pelunasan, tampilkan sisa bayar pelunasan
                                $sisa_pelunasan = $sisapercicilan;
                                $keterangan_bln .= " (Pelunasan " . formatAngka($sisa_pelunasan) . ")";
                            }
                        } else {
                            // Sebagian
                            $keterangan_bln = $nama_bulan[$d->bulan] . " (Sebagian)";
                        }

                        // Tambahkan ke string cicilan dan list bulan
                        if ($cicilan != "") {
                            $cicilan .= ", ";
                            $listbln .= ", ";
                        }
                        $cicilan .= $d->cicilan_ke;
                        $listbln .= $keterangan_bln;

                        $sisa -= $bayar;
                    }

                    Detailhistoribayarpendidikan::create([
                        'no_bukti' => $no_bukti,
                        'kode_biaya' => $kode_biaya[$i],
                        'kode_jenis_biaya' => $kode_jenis_biaya[$i],
                        'jumlah' => toNumber($jumlah[$i]),
                        'keterangan' => $keterangan[$i] . " " . $listbln,
                        'cicilan_ke' => $cicilan
                    ]);
                } else {
                    Detailhistoribayarpendidikan::create([
                        'no_bukti' => $no_bukti,
                        'kode_biaya' => $kode_biaya[$i],
                        'kode_jenis_biaya' => $kode_jenis_biaya[$i],
                        'jumlah' => toNumber($jumlah[$i]),
                        'keterangan' => $keterangan[$i],
                    ]);
                }
            }
            DB::commit();
            return response()->json(['success' => true, 'message' => 'Pembayaran berhasil ditambahkan', 'no_pendaftaran' => Crypt::encrypt($no_pendaftaran)], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => 'Pembayaran gagal ditambahkan ' . $e->getMessage()], 500);
        }
    }

    public function gethistoribayar($no_pendaftaran)
    {
        $no_pendaftaran = Crypt::decrypt($no_pendaftaran);
        $data['historibayar'] = Detailhistoribayarpendidikan::where('no_pendaftaran', $no_pendaftaran)
            ->select('pendidikan_historibayar_detail.no_bukti', 'tanggal', 'name', DB::raw('SUM(jumlah) as jumlah'))
            ->join('pendidikan_historibayar', 'pendidikan_historibayar_detail.no_bukti', '=', 'pendidikan_historibayar.no_bukti')
            ->join('users', 'pendidikan_historibayar.id_user', '=', 'users.id')
            ->groupBy('no_bukti', 'tanggal', 'name')
            ->orderBy('no_bukti', 'desc')
            ->get();
        return view('pembayaranpendidikan.gethistoribayar', $data);
    }

    public function destroy(Request $request)
    {
        $no_bukti = Crypt::decrypt($request->no_bukti);
        $pembayaran = Historibayarpendidikan::where('no_bukti', $no_bukti)->first();
        $no_pendaftaran = $pembayaran->no_pendaftaran;
        $cekSpp = Detailhistoribayarpendidikan::where('no_bukti', $no_bukti)
            ->where('kode_jenis_biaya', 'B07')
            ->get();
        DB::beginTransaction();
        try {
            if (count($cekSpp) > 0) {
                foreach ($cekSpp as $d) {
                    $kode_biaya = $d->kode_biaya;
                    $cicilan_ke = array_map('intval', explode(',', $d->cicilan_ke));

                    $rencana = Detailrencanaspp::join('spp_rencana', 'spp_rencana_detail.kode_rencana_spp', '=', 'spp_rencana.kode_rencana_spp')
                        ->where('no_pendaftaran', $no_pendaftaran)
                        ->where('kode_biaya', $kode_biaya)
                        ->whereIn('cicilan_ke', $cicilan_ke)
                        ->orderBy('cicilan_ke', 'desc')
                        ->get();

                    $mulaicicilan = Detailrencanaspp::join('spp_rencana', 'spp_rencana_detail.kode_rencana_spp', '=', 'spp_rencana.kode_rencana_spp')
                        ->where('no_pendaftaran', $no_pendaftaran)
                        ->where('kode_biaya', $kode_biaya)
                        ->whereIn('cicilan_ke', $cicilan_ke)
                        ->orderBy('cicilan_ke', 'desc')
                        ->first();

                    $sisa = $d->jumlah;
                    $i = $mulaicicilan->cicilan_ke;

                    foreach ($rencana as $d) {
                        if ($sisa >= $d->realisasi) {
                            Detailrencanaspp::where('kode_rencana_spp', $mulaicicilan->kode_rencana_spp)
                                ->where('cicilan_ke', $i)
                                ->update([
                                    'realisasi' =>  DB::raw('realisasi -' . $d->realisasi)
                                ]);

                            $sisa = $sisa - $d->realisasi;
                        } else {
                            if ($sisa != 0) {

                                Detailrencanaspp::where('kode_rencana_spp', $mulaicicilan->kode_rencana_spp)
                                    ->where('cicilan_ke', $i)
                                    ->update([
                                        'realisasi' =>  DB::raw('realisasi -' . $sisa)
                                    ]);
                                $sisa = $sisa - $sisa;
                            }
                        }

                        $i--;
                    }
                }
            }
            Historibayarpendidikan::where('no_bukti', $no_bukti)->delete();
            DB::commit();
            return response()->json(['success' => true, 'message' => 'Pembayaran berhasil dihapus', 'no_pendaftaran' => Crypt::encrypt($pembayaran->no_pendaftaran)], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => 'Pembayaran gagal dihapus ' . $e->getMessage()], 500);
        }
    }


    public function getsisatagihan(Request $request)
    {
        $no_pendaftaran = Crypt::decrypt($request->no_pendaftaran);
        $kode_biaya = $request->kode_biaya;
        $kode_jenis_biaya = $request->kode_jenis_biaya;

        $historibayar = Detailhistoribayarpendidikan::where('no_pendaftaran', $no_pendaftaran)
            ->join('pendidikan_historibayar', 'pendidikan_historibayar_detail.no_bukti', '=', 'pendidikan_historibayar.no_bukti')
            ->select(
                'no_pendaftaran',
                'kode_biaya',
                'kode_jenis_biaya',
                DB::raw('SUM(jumlah) as jmlbayar')
            )
            ->groupBy('no_pendaftaran', 'kode_biaya', 'kode_jenis_biaya');

        $biaya = Biayasiswa::where('siswa_biaya.no_pendaftaran', $no_pendaftaran)
            ->select(
                'konfigurasi_biaya_detail.*',
                'pendaftaran_potongan.jumlah as jumlah_potongan',
                'pembayaran_pendidikan_mutasi.jumlah as jumlah_mutasi',
                'jenis_biaya',
                'jmlbayar',
                'tahun_ajaran'
            )
            ->join('konfigurasi_biaya', 'konfigurasi_biaya.kode_biaya', '=', 'siswa_biaya.kode_biaya')
            ->join('konfigurasi_biaya_detail', 'konfigurasi_biaya_detail.kode_biaya', '=', 'konfigurasi_biaya.kode_biaya')
            ->join('jenis_biaya', 'jenis_biaya.kode_jenis_biaya', '=', 'konfigurasi_biaya_detail.kode_jenis_biaya')
            ->join('konfigurasi_tahun_ajaran', 'konfigurasi_tahun_ajaran.kode_ta', '=', 'konfigurasi_biaya.kode_ta')
            ->leftJoin('pendaftaran_potongan', function ($join) {
                $join->on('pendaftaran_potongan.kode_biaya', '=', 'konfigurasi_biaya.kode_biaya')
                    ->on('pendaftaran_potongan.kode_jenis_biaya', '=', 'konfigurasi_biaya_detail.kode_jenis_biaya')
                    ->on('pendaftaran_potongan.no_pendaftaran', '=', 'siswa_biaya.no_pendaftaran');
            })
            ->leftJoin('pembayaran_pendidikan_mutasi', function ($join) {
                $join->on('pembayaran_pendidikan_mutasi.kode_biaya', '=', 'konfigurasi_biaya.kode_biaya')
                    ->on('pembayaran_pendidikan_mutasi.kode_jenis_biaya', '=', 'konfigurasi_biaya_detail.kode_jenis_biaya')
                    ->on('pembayaran_pendidikan_mutasi.no_pendaftaran', '=', 'siswa_biaya.no_pendaftaran');
            })
            ->leftJoinSub($historibayar, 'historibayar', function ($join) {
                $join->on('historibayar.no_pendaftaran', '=', 'siswa_biaya.no_pendaftaran')
                    ->on('historibayar.kode_biaya', '=', 'konfigurasi_biaya.kode_biaya')
                    ->on('historibayar.kode_jenis_biaya', '=', 'konfigurasi_biaya_detail.kode_jenis_biaya');
            })

            ->where('konfigurasi_biaya_detail.kode_biaya', $kode_biaya)
            ->where('konfigurasi_biaya_detail.kode_jenis_biaya', $kode_jenis_biaya)
            ->orderBy('konfigurasi_biaya.kode_biaya', 'asc')
            ->orderBy('konfigurasi_biaya_detail.kode_jenis_biaya', 'asc')
            ->first();

        $sisatagihan = $biaya->jumlah - $biaya->jumlah_potongan - $biaya->jumlah_mutasi - $biaya->jmlbayar;

        return response()->json(['success' => true, 'sisatagihan' => $sisatagihan], 200);
    }

    public function showdetailbayar($no_bukti)
    {
        $no_bukti = Crypt::decrypt($no_bukti);
        $data['historibayar'] = Historibayarpendidikan::where('no_bukti', $no_bukti)
            ->join('users', 'pendidikan_historibayar.id_user', '=', 'users.id')
            ->first();
        $data['detail'] = Detailhistoribayarpendidikan::where('no_bukti', $no_bukti)
            ->join('jenis_biaya', 'pendidikan_historibayar_detail.kode_jenis_biaya', '=', 'jenis_biaya.kode_jenis_biaya')
            ->join('konfigurasi_biaya', 'pendidikan_historibayar_detail.kode_biaya', '=', 'konfigurasi_biaya.kode_biaya')
            ->join('konfigurasi_tahun_ajaran', 'konfigurasi_biaya.kode_ta', '=', 'konfigurasi_tahun_ajaran.kode_ta')
            ->orderBy('pendidikan_historibayar_detail.kode_jenis_biaya', 'asc')
            ->get();
        return view('pembayaranpendidikan.showdetailbayar', $data);
    }


    public function cetak($no_bukti)
    {
        $no_bukti = Crypt::decrypt($no_bukti);
        $data['historibayar'] = Historibayarpendidikan::where('no_bukti', $no_bukti)
            ->join('users', 'pendidikan_historibayar.id_user', '=', 'users.id')
            ->first();
        $data['detail'] = Detailhistoribayarpendidikan::where('no_bukti', $no_bukti)
            ->join('jenis_biaya', 'pendidikan_historibayar_detail.kode_jenis_biaya', '=', 'jenis_biaya.kode_jenis_biaya')
            ->join('konfigurasi_biaya', 'pendidikan_historibayar_detail.kode_biaya', '=', 'konfigurasi_biaya.kode_biaya')
            ->join('konfigurasi_tahun_ajaran', 'konfigurasi_biaya.kode_ta', '=', 'konfigurasi_tahun_ajaran.kode_ta')
            ->orderBy('pendidikan_historibayar_detail.kode_jenis_biaya', 'asc')
            ->get();
        return view('pembayaranpendidikan.cetak', $data);
    }
}
