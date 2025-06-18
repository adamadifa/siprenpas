<?php

namespace App\Http\Controllers;

use App\Models\Anggota;
use App\Models\Historibayarpembiayaan;
use App\Models\Jenispembiayaan;
use App\Models\Karyawananggota;
use App\Models\Pembiayaan;
use App\Models\Province;
use App\Models\Rencanapembiayaan;
use App\Models\User;
use App\Models\Userkaryawan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Yajra\DataTables\Facades\DataTables;

class PembiayaanController extends Controller
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


        $query = Pembiayaan::query();
        $query->join('koperasi_anggota', 'koperasi_pembiayaan.no_anggota', '=', 'koperasi_anggota.no_anggota');
        $query->join('koperasi_jenis_pembiayaan', 'koperasi_pembiayaan.kode_pembiayaan', '=', 'koperasi_jenis_pembiayaan.kode_pembiayaan');
        if (!empty($request->nama_anggota)) {
            $query->where('koperasi_anggota.nama_lengkap', 'like', "%" . $request->nama_anggota . "%");
        }
        $query->orderBy('tanggal', 'desc');
        $pembiayaan = $query->paginate(15);
        $pembiayaan->appends($request->all());

        $data['pembiayaan'] = $pembiayaan;
        return view('koperasi.pembiayaan.index', $data);
    }


    public function show($no_akad, Request $request)
    {
        $no_akad = Crypt::decrypt($no_akad);
        $pembiayaan = Pembiayaan::where('no_akad', $no_akad)
            ->join('koperasi_jenis_pembiayaan', 'koperasi_pembiayaan.kode_pembiayaan', '=', 'koperasi_jenis_pembiayaan.kode_pembiayaan')
            ->first();

        $anggota = Anggota::where('no_anggota', $pembiayaan->no_anggota)
            ->leftJoin('provinces', 'koperasi_anggota.id_province', '=', 'provinces.id')
            ->leftJoin('regencies', 'koperasi_anggota.id_regency', '=', 'regencies.id')
            ->leftJoin('districts', 'koperasi_anggota.id_district', '=', 'districts.id')
            ->leftJoin('villages', 'koperasi_anggota.id_village', '=', 'villages.id')
            ->select('koperasi_anggota.*', 'provinces.name as province_name', 'regencies.name as regency_name', 'districts.name as district_name', 'villages.name as village_name')
            ->first();

        $rencana = Rencanapembiayaan::where('no_akad', $no_akad)
            ->orderBy('cicilan_ke', 'asc')
            ->get();
        $histori = Historibayarpembiayaan::where('no_akad', $no_akad)
            ->orderBy('no_transaksi')
            ->get();

        $lasttransaksi = Historibayarpembiayaan::where('no_akad', $no_akad)
            ->orderBy('no_transaksi', 'desc')
            ->first();

        $data['pembiayaan'] = $pembiayaan;
        $data['rencana'] = $rencana;
        $data['histori'] = $histori;
        $data['anggota'] = $anggota;
        $data['lasttransaksi'] = $lasttransaksi;
        return view('koperasi.pembiayaan.show', $data);
    }


    public function createbayar($no_akad)
    {
        $no_akad = Crypt::decrypt($no_akad);
        $pembiayaan = Pembiayaan::where('no_akad', $no_akad)->first();
        $data['no_akad'] = $no_akad;
        $data['pembiayaan'] = $pembiayaan;
        return view('koperasi.pembiayaan.createbayar', $data);
    }

    public function storebayar($no_akad, Request $request)
    {
        $no_akad = Crypt::decrypt($no_akad);
        $request->validate([
            
            'jumlah' => 'required',
            'berita' => 'required',
        ]);
        $tanggal = $request->tanggal;
        $tgl = explode("-", $tanggal);
        $tahun = $tgl[0];
        $bulan = $tgl[1];
        if (strlen($bulan) > 1) {
            $bulan = $bulan;
        } else {
            $bulan = "0" . $bulan;
        }
        $format = "TSW" . substr($tahun, 2, 2) . $bulan;
        //Cek Simpanan Terakhir
        $lastpembayaran = Historibayarpembiayaan::select('no_transaksi')
            ->where(DB::raw('left(no_transaksi,7)'), $format)
            ->orderBy('no_transaksi', 'desc')
            ->first();

        $no_transaksi_terakhir = $lastpembayaran ? $lastpembayaran->no_transaksi : '';



        //dd($no_transaksi_terakhir);
        $no_transaksi = buatkode($no_transaksi_terakhir, $format . "-", 3);
        $rencana = Rencanapembiayaan::where('no_akad', $no_akad)
            ->whereRaw('jumlah != bayar')
            ->orderBy('cicilan_ke', 'asc')
            ->get();
        $mulaicicilan = Rencanapembiayaan::where('no_akad', $no_akad)
            ->whereRaw('jumlah != bayar')
            ->orderBy('cicilan_ke', 'asc')
            ->first();
        DB::beginTransaction();
        try {

            $jumlah = toNumber($request->jumlah);
            $sisa = $jumlah;
            $cicilan = "";
            $i = $mulaicicilan->cicilan_ke;
            foreach ($rencana as $d) {
                if ($sisa >= $d->jumlah) {
                    Rencanapembiayaan::where('no_akad', $no_akad)
                        ->where('cicilan_ke', $i)
                        ->update([
                            'bayar' => $d->jumlah
                        ]);
                    //$cicilan .=  $d->cicilan_ke . ",";
                    $sisapercicilan = $d->jumlah - $d->bayar;
                    $sisa = $sisa - $sisapercicilan;

                    if ($sisa == 0) {
                        $cicilan .=  $d->cicilan_ke;
                    } else {
                        $cicilan .=  $d->cicilan_ke . ",";
                    }

                    $coba = $cicilan;
                } else {
                    if ($sisa != 0) {
                        $sisapercicilan = $d->jumlah - $d->bayar;
                        if ($d->bayar != 0) {
                            if ($sisa >= $sisapercicilan) {
                                Rencanapembiayaan::where('no_akad', $no_akad)
                                    ->where('cicilan_ke', $i)
                                    ->update([
                                        'bayar' =>  DB::raw('bayar +' . $sisapercicilan)
                                    ]);
                                $cicilan .= $d->cicilan_ke . ",";
                                $sisa = $sisa - $sisapercicilan;
                            } else {
                                Rencanapembiayaan::where('no_akad', $no_akad)
                                    ->where('cicilan_ke', $i)
                                    ->update([
                                        'bayar' =>  DB::raw('bayar +' . $sisa)
                                    ]);
                                //$cicilan .= $d->cicilan_ke . ",";
                                $sisa = $sisa - $sisa;
                                if ($sisa == 0) {
                                    $cicilan .=  $d->cicilan_ke;
                                } else {
                                    $cicilan .=  $d->cicilan_ke . ",";
                                }
                            }
                        } else {
                            Rencanapembiayaan::where('no_akad', $no_akad)
                                ->where('cicilan_ke', $i)
                                ->update([
                                    'bayar' =>  DB::raw('bayar +' . $sisa)
                                ]);
                            //$cicilan .= $d->cicilan_ke;
                            $sisa = $sisa - $sisa;
                            if ($sisa == 0) {
                                $cicilan .=  $d->cicilan_ke;
                            } else {
                                $cicilan .=  $d->cicilan_ke . ",";
                            }
                        }
                    }
                }
                $i++;
            }

            //$c = '$cicilan';
            Historibayarpembiayaan::create([
                'no_transaksi' => $no_transaksi,
                'no_akad' => $no_akad,
                'tanggal' => $request->tanggal,
                'cicilan_ke' => $cicilan,
                'jumlah' => toNumber($request->jumlah),
                'id_petugas' => Auth::user()->id
            ]);

            Pembiayaan::where('no_akad', $no_akad)
                ->update([
                    'jmlbayar' => DB::raw('jmlbayar +' . toNumber($request->jumlah))
                ]);

            DB::commit();

            return Redirect::back()->with(messageSuccess('Data Berhasil di Simpan'));
        } catch (\Exception $e) {
            DB::rollback();
            dd($e);
            return Redirect::back()->with(messageError($e->getMessage()));
        }
    }


    function deletebayar($no_transaksi)
    {
        $no_transaksi = Crypt::decrypt($no_transaksi);
        $trans = Historibayarpembiayaan::where('no_transaksi', $no_transaksi)->first();
        $cicilan_ke = array_map('intval', explode(',', $trans->cicilan_ke));
        $rencana = Rencanapembiayaan::where('no_akad', $trans->no_akad)
            ->whereIn('cicilan_ke', $cicilan_ke)
            ->orderBy('cicilan_ke', 'desc')
            ->get();
        //dd($rencana);
        $mulaicicilan = Rencanapembiayaan::where('no_akad', $trans->no_akad)
            ->whereIn('cicilan_ke', $cicilan_ke)
            ->orderBy('cicilan_ke', 'desc')
            ->first();
        //dd($mulaicicilan);
        DB::beginTransaction();
        try {
            $sisa = $trans->jumlah;
            $i = $mulaicicilan->cicilan_ke;
            foreach ($rencana as $d) {
                if ($sisa >= $d->bayar) {
                    Rencanapembiayaan::where('no_akad', $trans->no_akad)
                        ->where('cicilan_ke', $i)
                        ->update([
                            'bayar' => DB::raw('bayar -' . $d->bayar)
                        ]);
                    $sisa = $sisa - $d->bayar;
                } else {
                    if ($sisa != 0) {
                        Rencanapembiayaan::where('no_akad', $trans->no_akad)
                            ->where('cicilan_ke', $i)
                            ->update([
                                'bayar' =>  DB::raw('bayar -' . $sisa)
                            ]);
                        $sisa = $sisa - $sisa;
                    }
                }

                $i--;
            }
            Historibayarpembiayaan::where('no_transaksi', $no_transaksi)
                ->delete();

            Pembiayaan::where('no_akad', $trans->no_akad)
                ->update([
                    'jmlbayar' => DB::raw('jmlbayar -' . $trans->jumlah)
                ]);
            DB::commit();

            return Redirect::back()->with(messageSuccess('Data Berhasil di Hapus'));
        } catch (\Exception $e) {
            DB::rollback();
            //dd($e);
            return Redirect::back()->with(messageError($e->getMessage()));
        }
    }


    function is_decimal($val)
    {
        return is_numeric($val) && floor($val) != $val;
    }
    public function updaterencana($no_akad)
    {

        $no_akad = Crypt::decrypt($no_akad);

        $pembiayaan = Pembiayaan::where('no_akad', $no_akad)->first();
        $rencana = Rencanapembiayaan::where('no_akad', $no_akad)->where('cicilan_ke', 1)->first();
        $bln = $rencana->bulan;
        $tahunangsuran = $rencana->tahun;
        $angsuran = $pembiayaan->jangka_waktu;
        $jml_pembiayaan = $pembiayaan->jumlah;
        $persentase = $pembiayaan->persentase;
        $jumlah_pinjaman = $jml_pembiayaan + ($jml_pembiayaan * ($persentase / 100));
        $cicilanperbulan = $jumlah_pinjaman / $angsuran;
        //dd($cicilanperbulan);
        if ($this->is_decimal($cicilanperbulan)) {
            $jmlangsuran = $cicilanperbulan;
            $jmlangsuran = ceil($jmlangsuran);
            //dd(substr($jmlangsuran, -3));
            if (substr($jmlangsuran, -3) > 500) {
                $jumlah_angsuran = round($jmlangsuran, -3);
            } else {
                $jumlah_angsuran = round($jmlangsuran, -3) + 1000;
            }
        } else {
            $jumlah_angsuran = $cicilanperbulan;
        }




        // echo "Jumlah Angsuran * Angsuran = " .  $jumlah_angsuran * ($angsuran - 1) . "<br>";
        // echo "Jumlah Pinjaman = " .  $jumlah_pinjaman . "<br>";
        // echo "Sisa = " . ($jumlah_pinjaman - ($jumlah_angsuran * ($angsuran - 1))) . "<br>";
        $cicilan_terakhir =  ($jumlah_pinjaman - ($jumlah_angsuran * ($angsuran - 1)));
        //echo $cicilan_terakhir;

        DB::beginTransaction();
        try {
            Rencanapembiayaan::where('no_akad', $no_akad)->delete();
            for ($i = 1; $i <= $angsuran; $i++) {
                if ($bln > 12) {
                    $blncicilan = $bln - 12;
                    $tahun = $tahunangsuran + 1;
                } else {
                    $blncicilan = $bln;
                    $tahun = $tahunangsuran;
                }


                if ($i == $angsuran) {
                    $cicilan = $cicilan_terakhir;
                } else {
                    $cicilan = $jumlah_angsuran;
                }

                Rencanapembiayaan::create([
                    'no_akad' => $no_akad,
                    'cicilan_ke' => $i,
                    'bulan' => $blncicilan,
                    'tahun' => $tahun,
                    'bayar' => 0,
                    'jumlah' => $cicilan
                ]);

                // echo "No Akad :" . $no_akad . "<br>";
                // echo "Cicilan Ke :" . $i . "<br>";
                // echo "Bulan :" . $blncicilan . "<br>";
                // echo "Tahun :" . $tahun . "<br>";
                // echo "Jumlah :" . $cicilan . "<br>";
                $bln++;
            }


            $jumlah = $pembiayaan->jmlbayar;
            $sisa = $jumlah;
            $cicilan = "";
            $mulaicicilan = Rencanapembiayaan::where('no_akad', $no_akad)
                ->whereRaw('jumlah != bayar')
                ->orderBy('cicilan_ke', 'asc')
                ->first();
            // dd($mulaicicilan);
            $i = $mulaicicilan->cicilan_ke;
            $rencana2 = Rencanapembiayaan::where('no_akad', $no_akad)
                ->whereRaw('jumlah != bayar')
                ->orderBy('cicilan_ke', 'asc')
                ->get();

            //dd($sisa);

            foreach ($rencana2 as $d) {

                if ($sisa >= $d->jumlah) {
                    Rencanapembiayaan::where('no_akad', $no_akad)
                        ->where('cicilan_ke', $i)
                        ->update([
                            'bayar' => $d->jumlah
                        ]);
                    //$cicilan .=  $d->cicilan_ke . ",";
                    $sisapercicilan = $d->jumlah - $d->bayar;
                    $sisa = $sisa - $sisapercicilan;

                    if ($sisa == 0) {
                        $cicilan .=  $d->cicilan_ke;
                    } else {
                        $cicilan .=  $d->cicilan_ke . ",";
                    }

                    $coba = $cicilan;
                } else {
                    if ($sisa != 0) {
                        $sisapercicilan = $d->jumlah - $d->bayar;
                        if ($d->bayar != 0) {
                            if ($sisa >= $sisapercicilan) {
                                Rencanapembiayaan::where('no_akad', $no_akad)
                                    ->where('cicilan_ke', $i)
                                    ->update([
                                        'bayar' =>  DB::raw('bayar +' . $sisapercicilan)
                                    ]);
                                $cicilan .= $d->cicilan_ke . ",";
                                $sisa = $sisa - $sisapercicilan;
                            } else {
                                Rencanapembiayaan::where('no_akad', $no_akad)
                                    ->where('cicilan_ke', $i)
                                    ->update([
                                        'bayar' =>  DB::raw('bayar +' . $sisa)
                                    ]);
                                //$cicilan .= $d->cicilan_ke . ",";
                                $sisa = $sisa - $sisa;
                                if ($sisa == 0) {
                                    $cicilan .=  $d->cicilan_ke;
                                } else {
                                    $cicilan .=  $d->cicilan_ke . ",";
                                }
                            }
                        } else {
                            Rencanapembiayaan::where('no_akad', $no_akad)
                                ->where('cicilan_ke', $i)
                                ->update([
                                    'bayar' =>  DB::raw('bayar +' . $sisa)
                                ]);
                            //$cicilan .= $d->cicilan_ke;
                            $sisa = $sisa - $sisa;
                            if ($sisa == 0) {
                                $cicilan .=  $d->cicilan_ke;
                            } else {
                                $cicilan .=  $d->cicilan_ke . ",";
                            }
                        }
                    }
                }
                $i++;
            }
            DB::commit();
            return Redirect::back()->with(['success' => 'Berhasil Di update']);
        } catch (\Exception $e) {
            DB::rollBack();
            dd($e);
        }
    }


    public function create()
    {
        $data['provinsi'] = Province::orderBy('name')->get();
        $data['pendidikan'] = config('global.list_pendidikan ');
        $data['jenis_pembiayaan'] = Jenispembiayaan::orderBy('kode_pembiayaan')->get();
        return view('koperasi.pembiayaan.create', $data);
    }


    public function createmobile(){
        $user = User::where('id', auth()->user()->id)->first();
        $userkaryawan = Userkaryawan::where('id_user', $user->id)->first();
        $karyawan_anggota= Karyawananggota::where('npp', $userkaryawan->npp)->first();
        $anggota = Anggota::where('no_anggota',$karyawan_anggota->no_anggota)->first();
        $data['anggota'] = $anggota;
        $data['provinsi'] = Province::orderBy('name')->get();
        $data['pendidikan'] = config('global.list_pendidikan ');
        $data['jenis_pembiayaan'] = Jenispembiayaan::orderBy('kode_pembiayaan')->get();
        return view('koperasi.pembiayaan.createmobile',$data);
    }


    public function store(Request $request)
    {
        $request->validate([
            
            'no_anggota' => 'required',
            'nik' => 'required',
            'nama_lengkap' => 'required',
            'tempat_lahir' => 'required',
            'tanggal_lahir' => 'required',
            'alamat' => 'required',
            'jenis_kelamin' => 'required',
            'pendidikan_terakhir' => 'required',
            'status_pernikahan' => 'required',
            'id_province' => 'required',
            'id_regency' => 'required',
            'id_district' => 'required',
            'id_village' => 'required',
            'status_tinggal' => 'required',
            'no_hp' => 'required',
            'alamat' => 'required',
            'id_province' => 'required',
            'id_regency' => 'required',
            'id_district' => 'required',
            'id_village' => 'required',
            'status_tinggal' => 'required',
            'kode_pos' => 'required',
            'kode_pembiayaan' => 'required',
            'persentase' => 'required',
            'jangka_waktu' => 'required',
            'jumlah' => 'required',
            'jumlah_pengembalian' => 'required',
            'keperluan' => 'required',
            'jaminan' => 'required',
        ]);

        DB::beginTransaction();
        try {
            //code...
            $dataanggota = [
                'nik' => $request->nik,
                'nama_lengkap' => $request->nama_lengkap,
                'tempat_lahir' => $request->tempat_lahir,
                'tanggal_lahir' => $request->tanggal_lahir,
                'jenis_kelamin' => $request->jenis_kelamin,
                'pendidikan_terakhir' => $request->pendidikan_terakhir,
                'status_pernikahan' => $request->status_pernikahan,
                'id_province' => $request->id_province,
                'id_regency' => $request->id_regency,
                'id_district' => $request->id_district,
                'id_village' => $request->id_village,
                'status_tinggal' => $request->status_tinggal,
                'no_hp' => $request->no_hp,
                'alamat' => $request->alamat,
                'id_province' => $request->id_province,
                'id_regency' => $request->id_regency,
                'id_district' => $request->id_district,
                'id_village' => $request->id_village,
                'status_tinggal' => $request->status_tinggal,
                'kode_pos' => $request->kode_pos,
            ];

            $tanggal = $request->tanggal;
            $tgl = explode("-", $tanggal);
            $tahun = $tgl[0];
            $bulan = $tgl[1];
            if (strlen($bulan) > 1) {
                $bulan = $bulan;
            } else {
                $bulan = "0" . $bulan;
            }
            $format = "PB" . substr($tahun, 2, 2) . $bulan;

            $lastpembiayaan = Pembiayaan::select('no_akad')
                ->where(DB::raw('left(no_akad,6)'), $format)
                ->orderBy('no_akad', 'desc')
                ->first();

            //dd($ceksimpanan);
            $last_no_akad = $lastpembiayaan ? $lastpembiayaan->no_akad : '';

            $no_akad = buatkode($last_no_akad, $format . "-", 3);

            $tagihan = str_replace(".", "", $request->jumlah) + (str_replace(".", "", $request->jumlah) * ($request->persentase / 100));

            $cicilanperbulan = ROUND($tagihan / $request->jangka_waktu);
            $cicilan_terakhir = $cicilanperbulan + ($tagihan - ($cicilanperbulan * $request->jangka_waktu));


            // if ($this->is_decimal($cicilanperbulan)) {
            //     $jmlangsuran = $cicilanperbulan;
            //     $jmlangsuran = ceil($jmlangsuran);
            //     //dd(substr($jmlangsuran, -3));
            //     if (substr($jmlangsuran, -3) > 500) {
            //         $jumlah_angsuran = round($jmlangsuran, -3);
            //     } else {
            //         $jumlah_angsuran = round($jmlangsuran, -3) + 1000;
            //     }
            // } else {
            //     $jumlah_angsuran = $cicilanperbulan;
            // }

            // $angsuran = $request->jangka_waktu;

            // $cicilan_terakhir =  ($tagihan - ($jumlah_angsuran * ($angsuran - 1)));


            Anggota::where('no_anggota', $request->no_anggota)->update($dataanggota);
            Pembiayaan::create([
                'no_akad' => $no_akad,
                'tanggal' => $request->tanggal,
                'no_anggota' => $request->no_anggota,
                'kode_pembiayaan' => $request->kode_pembiayaan,
                'jumlah' => toNumber($request->jumlah),
                'persentase' => $request->persentase,
                'jangka_waktu' => $request->jangka_waktu,
                'keperluan' => $request->keperluan,
                'jaminan' => $request->jaminan,
                'jmlbayar' => 0,
                'ktp_pemohon' => 1,
                'ktp_pasangan' => 1,
                'kartu_keluarga' => 1,
                'struk_gaji' => 1,
            ]);
            $bulan_cicilan = $bulan + 1;
            $tahun_cicilan = $tahun;
            $thncicilan = $tahun_cicilan;
            for ($i = 1; $i <= $request->jangka_waktu; $i++) {
                if ($bulan_cicilan > 12) {
                    $blncicilan = $bulan_cicilan - 12;
                    $thncicilan = $thncicilan + 1;
                    $bulan_cicilan = 1;
                } else {
                    $blncicilan = $bulan_cicilan;
                    $thncicilan = $thncicilan;
                }

                if ($i == $request->jangka_waktu) {
                    $cicilan = $cicilan_terakhir;
                } else {
                    $cicilan = $cicilanperbulan;
                }


                Rencanapembiayaan::create([
                    'no_akad' => $no_akad,
                    'cicilan_ke' => $i,
                    'bulan' => $blncicilan,
                    'tahun' => $thncicilan,
                    'jumlah' => $cicilan,
                    'bayar' => 0
                ]);

                $bulan_cicilan++;
            }
            // for ($i = 1; $i <= $angsuran; $i++) {
            //     if ($bln > 12) {
            //         $blncicilan = $bln - 12;
            //         $tahun = $tahun + 1;
            //     } else {
            //         $blncicilan = $bln;
            //         $tahun = $tahun;
            //     }


            //     if ($i == $angsuran) {
            //         $cicilan = $cicilan_terakhir;
            //     } else {
            //         $cicilan = $jumlah_angsuran;
            //     }

            //     Rencanapembiayaan::create([
            //         'no_akad' => $no_akad,
            //         'cicilan_ke' => $i,
            //         'bulan' => $blncicilan,
            //         'tahun' => $tahun,
            //         'jumlah' => $cicilan,
            //         'bayar' => 0
            //     ]);

            //     // echo "No Akad :" . $no_akad . "<br>";
            //     // echo "Cicilan Ke :" . $i . "<br>";
            //     // echo "Bulan :" . $blncicilan . "<br>";
            //     // echo "Tahun :" . $tahun . "<br>";
            //     // echo "Jumlah :" . $cicilan . "<br>";
            //     $bln++;
            // }

            DB::commit();
            return Redirect::back()->with(messageSuccess('Berhasil Disimpan'));
        } catch (\Exception $e) {
            DB::rollBack();
            dd($e);
            return Redirect::back()->with(messageError('Gagal Disimpan'));
        }
    }

    public function destroy($no_akad)
    {
        $no_akad = Crypt::decrypt($no_akad);
        Pembiayaan::where('no_akad', $no_akad)->delete();
        return Redirect::back()->with(messageSuccess('Berhasil Dihapus'));
    }


    public function editrencana($no_akad)
    {
        $no_akad = Crypt::decrypt($no_akad);
        $pembiayaan = Pembiayaan::where('no_akad', $no_akad)
            ->join('koperasi_anggota', 'koperasi_pembiayaan.no_anggota', '=', 'koperasi_anggota.no_anggota')
            ->join('koperasi_jenis_pembiayaan', 'koperasi_pembiayaan.kode_pembiayaan', '=', 'koperasi_jenis_pembiayaan.kode_pembiayaan')
            ->first();
        $rencana = Rencanapembiayaan::where('no_akad', $no_akad)->get();
        $data['pembiayaan'] = $pembiayaan;
        $data['rencana'] = $rencana;
        return view('koperasi.pembiayaan.editrencana', $data);
    }

    public function updaterencanacicilan(Request $request, $no_akad)
    {
        $no_akad = Crypt::decrypt($no_akad);
        $cicilan_ke = $request->cicilan_ke;
        $jumlah = $request->jumlah;
        try {
            for ($i = 0; $i < count($cicilan_ke); $i++) {
                Rencanapembiayaan::where('no_akad', $no_akad)->where('cicilan_ke', $cicilan_ke[$i])->update([
                    'jumlah' => toNumber($jumlah[$i])
                ]);
            }
            DB::commit();
            return Redirect::back()->with(messageSuccess('Berhasil Disimpan'));
        } catch (\Throwable $th) {
            //throw $th;
        }
        return Redirect::back()->with(messageSuccess('Berhasil Disimpan'));
    }


    public function cetakkwitansi($no_transaksi)
    {
        $no_transaksi = Crypt::decrypt($no_transaksi);
        $data['transaksi'] = Historibayarpembiayaan::where('no_transaksi', $no_transaksi)
            ->select('koperasi_pembiayaan_historibayar.*', 'nama_lengkap', 'keperluan')
            ->join('koperasi_pembiayaan', 'koperasi_pembiayaan_historibayar.no_akad', '=', 'koperasi_pembiayaan.no_akad')
            ->join('koperasi_anggota', 'koperasi_pembiayaan.no_anggota', '=', 'koperasi_anggota.no_anggota')
            ->first();

        return view('koperasi.pembiayaan.cetakkwitansi', $data);
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

        $pembiayaan = Pembiayaan::where('no_anggota', $no_anggota)
            ->join('koperasi_jenis_pembiayaan', 'koperasi_pembiayaan.kode_pembiayaan', '=', 'koperasi_jenis_pembiayaan.kode_pembiayaan')
            ->orderBy('tanggal', 'desc')
            ->get();
        $data['pembiayaan'] = $pembiayaan;
        return view('koperasi.pembiayaan.showmobile', $data);
    }

    
    public function showdetail($no_akad)
    {
        $no_akad = Crypt::decrypt($no_akad);
        $pembiayaan = Pembiayaan::where('no_akad', $no_akad)
            ->join('koperasi_jenis_pembiayaan', 'koperasi_pembiayaan.kode_pembiayaan', '=', 'koperasi_jenis_pembiayaan.kode_pembiayaan')
            ->first();
        $rencanapembiayaan = Rencanapembiayaan::where('no_akad', $no_akad)->get();
        $data['pembiayaan'] = $pembiayaan;
        $data['rencanapembiayaan'] = $rencanapembiayaan;
        return view('koperasi.pembiayaan.showdetail', $data);
    }
}
