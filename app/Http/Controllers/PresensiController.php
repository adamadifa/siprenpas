<?php

namespace App\Http\Controllers;

use App\Models\Cabang;
use App\Models\Jamkerja;
use App\Models\Karyawan;
use App\Models\Presensi;
use App\Models\Setjamkerjabydate;
use App\Models\Setjamkerjabyday;
use App\Models\Unit;
use App\Models\User;
use App\Models\Userkaryawan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;

class PresensiController extends Controller
{

    public function index(Request $request)
    {

        $tanggal = !empty($request->tanggal) ? $request->tanggal : date('Y-m-d');
        $presensi = Presensi::join('konfigurasi_jam_kerja', 'presensi.kode_jam_kerja', '=', 'konfigurasi_jam_kerja.kode_jam_kerja')
            ->select(
                'presensi.id',
                'presensi.npp',
                'presensi.tanggal',
                'presensi.kode_jam_kerja',
                'nama_jam_kerja',
                'jam_masuk',
                'jam_pulang',
                'jam_in',
                'foto_in',
                'jam_out',
                'foto_out',
                'status'
            )
            ->where('presensi.tanggal', $tanggal);

        $query = Karyawan::query();
        $query->select(
            'karyawan.npp',
            'nama_lengkap',
            'presensi.tanggal as tanggal_presensi',
            'presensi.jam_in',
            'presensi.kode_jam_kerja',
            'nama_jam_kerja',
            'jam_masuk',
            'jam_pulang',
            'jam_in',
            'jam_out',
            'presensi.status',
            'nama_jabatan',
            'nama_unit',
            'presensi.id',
            'karyawan.pin',
            'karyawan.status_karyawan'
        );
        $query->leftjoinSub($presensi, 'presensi', function ($join) {
            $join->on('karyawan.npp', '=', 'presensi.npp');
        });
        $query->join('jabatan', 'karyawan.kode_jabatan', '=', 'jabatan.kode_jabatan');
        $query->join('unit', 'karyawan.kode_unit', '=', 'unit.kode_unit');
        if (!empty($request->kode_unit)) {
            $query->where('karyawan.kode_unit', $request->kode_unit);
        }

        if (!empty($request->nama_karyawan)) {
            $query->where('karyawan.nama_lengkap', 'like', '%' . $request->nama_karyawan . '%');
        }

        if (auth()->user()->kode_unit != 'U06') {
            $query->where('karyawan.kode_unit', auth()->user()->kode_unit);
        }

        $query->where('karyawan.status', 1);
        $query->orderBy('nama_lengkap', 'asc');
        $karyawan = $query->paginate(30);
        $karyawan->appends(request()->all());
        $unit = Unit::orderBy('kode_unit')->get();
        $data['karyawan'] = $karyawan;
        $u = new Unit();
        $data['unit'] = $u->getUnit();
        return view('presensi.index', $data);
    }
    public function create($kode_jam_kerja = null)
    {

        //Get Data Karyawan By User
        $user = User::where('id', auth()->user()->id)->first();
        $userkaryawan = Userkaryawan::where('id_user', $user->id)->first();
        $karyawan = Karyawan::where('npp', $userkaryawan->npp)->first();

        // //Cek Lokasi Kantor
        $lokasi_kantor = Cabang::where('kode_cabang', 'PST')->first();

        //Cek Lintas Hari
        $hariini = date("Y-m-d");
        $jamsekarang = date("H:i");
        $tgl_sebelumnya = date('Y-m-d', strtotime("-1 days", strtotime($hariini)));
        $cekpresensi_sebelumnya = Presensi::join('konfigurasi_jam_kerja', 'presensi.kode_jam_kerja', '=', 'konfigurasi_jam_kerja.kode_jam_kerja')
            ->where('tanggal', $tgl_sebelumnya)
            ->where('npp', $karyawan->npp)
            ->first();

        $ceklintashari_presensi = $cekpresensi_sebelumnya != null  ? $cekpresensi_sebelumnya->lintashari : 0;

        if ($ceklintashari_presensi == 1) {
            if ($jamsekarang < "08:00") {
                $hariini = $tgl_sebelumnya;
            }
        }

        $namahari = getnamaHari(date('D', strtotime($hariini)));

        // $kode_dept = $karyawan->kode_dept;

        //Cek Presensi
        $presensi = Presensi::where('npp', $karyawan->npp)->where('tanggal', $hariini)->first();


        if ($kode_jam_kerja == null) {
            //Cek Jam Kerja By Date
            $jamkerja = Setjamkerjabydate::join('konfigurasi_jam_kerja', 'presensi_jamkerja_bydate.kode_jam_kerja', '=', 'konfigurasi_jam_kerja.kode_jam_kerja')
                ->where('npp', $karyawan->npp)
                ->where('tanggal', $hariini)
                ->first();

            //Jika Tidak Memiliki Jam Kerja By Date
            if ($jamkerja == null) {
                //Cek Jam Kerja harian / Jam Kerja Khusus / Jam Kerja Per Orangannya
                $jamkerja = Setjamkerjabyday::join('konfigurasi_jam_kerja', 'presensi_jamkerja_byday.kode_jam_kerja', '=', 'konfigurasi_jam_kerja.kode_jam_kerja')
                    ->where('npp', $karyawan->npp)->where('hari', $namahari)->first();

                // Jika Jam Kerja Harian Kosong
                if ($jamkerja == null) {
                    $jamkerja = Jamkerja::where('kode_jam_kerja', 'JK01')->first();
                }
            }
        } else {
            $jamkerja = Jamkerja::where('kode_jam_kerja', $kode_jam_kerja)->first();
        }


        // $ceklibur = Detailharilibur::join('hari_libur', 'hari_libur_detail.kode_libur', '=', 'hari_libur.kode_libur')
        //     ->where('npp', $karyawan->npp)
        //     ->where('tanggal', $hariini)
        //     ->first();
        // $data['harilibur'] = $ceklibur;

        if ($presensi != null && $presensi->status != 'h') {
            return view('presensi.notif_izin');
        } else if ($jamkerja == null) {
            return view('presensi.notif_jamkerja');
        }

        $data['hariini'] = $hariini;
        $data['jam_kerja'] = $jamkerja;
        $data['lokasi_kantor'] = $lokasi_kantor;
        $data['presensi'] = $presensi;


        return view('presensi.create', $data);
    }


    public function store(Request $request)
    {
        $user = User::where('id', auth()->user()->id)->first();
        $userkaryawan = Userkaryawan::where('id_user', $user->id)->first();
        $karyawan = Karyawan::where('npp', $userkaryawan->npp)->first();
        $status_lock_location = $karyawan->lock_location;

        $status = $request->status;
        $lokasi = $request->lokasi;
        $kode_jam_kerja = $request->kode_jam_kerja;



        $tanggal_sekarang = date("Y-m-d");
        $jam_sekarang = date("H:i");

        $tanggal_kemarin = date("Y-m-d", strtotime("-1 days"));

        $tanggal_besok = date("Y-m-d", strtotime("+1 days"));

        //Cek Presensi Kemarin
        $presensi_kemarin = Presensi::where('npp', $karyawan->npp)
            ->join('konfigurasi_jam_kerja', 'presensi.kode_jam_kerja', '=', 'konfigurasi_jam_kerja.kode_jam_kerja')
            ->where('npp', $karyawan->npp)
            ->where('tanggal', $tanggal_kemarin)->first();

        $lintas_hari = $presensi_kemarin ? $presensi_kemarin->lintashari : 0;

        //Jika Presensi Kemarin Status Lintas Hari nya 1 Makan Tanggal Presensi Sekarang adalah Tanggal Kemarin
        $tanggal_presensi = $lintas_hari == 1 ? $tanggal_kemarin : $tanggal_sekarang;

        //Get Lokasi User
        $koordinat_user = explode(",", $lokasi);
        $latitude_user = $koordinat_user[0];
        $longitude_user = $koordinat_user[1];

        //Get Lokasi Kantor
        $cabang = Cabang::where('kode_cabang', 'PST')->first();
        $lokasi_kantor = $cabang->lokasi_cabang;
        $koordinat_kantor = explode(",", $lokasi_kantor);
        $latitude_kantor = $koordinat_kantor[0];
        $longitude_kantor = $koordinat_kantor[1];

        $jarak = hitungjarak($longitude_kantor, $latitude_kantor, $latitude_user, $longitude_user);


        $radius = round($jarak["meters"]);

        $tanggal_pulang = $lintas_hari == 1 ? $tanggal_besok : $tanggal_sekarang;

        $in_out = $status == 1 ? "in" : "out";
        $image = $request->image;
        $folderPath = "public/uploads/absensi/";
        $formatName = $karyawan->npp . "-" . $tanggal_presensi . "-" . $in_out;
        $image_parts = explode(";base64", $image);
        $image_base64 = base64_decode($image_parts[1]);
        $fileName = $formatName . ".png";
        $file = $folderPath . $fileName;

        $jam_kerja = Jamkerja::where('kode_jam_kerja', $kode_jam_kerja)->first();

        $jam_presensi = $tanggal_sekarang . " " . $jam_sekarang;

        $jam_masuk = $tanggal_presensi . " " . date('H:i', strtotime($jam_kerja->jam_masuk));
        //Jam Mulai Absen adalah 60 Menit Sebelum Jam Masuk
        $jam_mulai_masuk = $tanggal_presensi . " " . date('H:i', strtotime('-60 minutes', strtotime($jam_masuk)));

        //Jamulai Absen Pulang adalah 1 Jam dari Jam Masuks
        $jam_mulai_pulang = $tanggal_presensi . " " . date('H:i', strtotime('+60 minutes', strtotime($jam_masuk)));

        $jam_pulang = $tanggal_pulang . " " . $jam_kerja->jam_pulang;



        //Cek Radius
        //dd($jam_presensi . " " . $jam_mulai_masuk);
        $presensi_hariini = Presensi::where('npp', $karyawan->npp)
            ->where('tanggal', $tanggal_presensi)
            ->first();
        if ($status_lock_location == 1 && $radius > $cabang->radius_cabang) {
            return response()->json(['status' => false, 'message' => 'Anda Berada Di Luar Radius Kantor, Jarak Anda ' . formatAngka($radius) . ' Meters Dari Kantor', 'notifikasi' => 'notifikasi_radius'], 400);
        } else {
            if ($status == 1) {
                if ($presensi_hariini && $presensi_hariini->jam_in != null) {
                    return response()->json(['status' => false, 'message' => 'Anda Sudah Absen Masuk Hari Ini', 'notifikasi' => 'notifikasi_sudahabsen'], 400);
                } else {
                    try {
                        if ($presensi_hariini != null) {
                            Presensi::where('id', $presensi_hariini->id)->update([
                                'jam_in' => $jam_presensi,
                                'lokasi_in' => $lokasi,
                                'foto_in' => $fileName
                            ]);
                        } else {
                            Presensi::create([
                                'npp' => $karyawan->npp,
                                'tanggal' => $tanggal_presensi,
                                'jam_in' => $jam_presensi,
                                'jam_out' => null,
                                'lokasi_in' => $lokasi,
                                'lokasi_out' => null,
                                'foto_in' => $fileName,
                                'foto_out' => null,
                                'kode_jam_kerja' => $kode_jam_kerja,
                                'status' => 'h'
                            ]);
                        }
                        Storage::put($file, $image_base64);

                        return response()->json(['status' => true, 'message' => 'Berhasil Absen Masuk', 'notifikasi' => 'notifikasi_absenmasuk'], 200);
                    } catch (\Exception $e) {
                        return response()->json(['status' => false, 'message' => $e->getMessage()], 400);
                    }
                }
            } else {
                try {
                    if ($presensi_hariini != null) {
                        Presensi::where('id', $presensi_hariini->id)->update([
                            'jam_out' => $jam_presensi,
                            'lokasi_out' => $lokasi,
                            'foto_out' => $fileName
                        ]);
                    } else {
                        Presensi::create([
                            'npp' => $karyawan->npp,
                            'tanggal' => $tanggal_presensi,
                            'jam_in' => null,
                            'jam_out' => $jam_presensi,
                            'lokasi_in' => null,
                            'lokasi_out' => $lokasi,
                            'foto_in' => null,
                            'foto_out' => $fileName,
                            'kode_jam_kerja' => $kode_jam_kerja,
                            'status' => 'h'
                        ]);
                    }
                    Storage::put($file, $image_base64);
                    return response()->json(['status' => true, 'message' => 'Berhasil Absen Pulang', 'notifikasi' => 'notifikasi_absenpulang'], 200);
                } catch (\Exception $e) {
                    return response()->json(['status' => false, 'message' => $e->getMessage()], 400);
                }
            }
        }
    }


    public function show($id, $status)
    {
        $presensi = Presensi::where('id', $id)
            ->join('karyawan', 'presensi.npp', '=', 'karyawan.npp')
            ->join('unit', 'karyawan.kode_unit', '=', 'unit.kode_unit')
            ->first();
        $cabang = Cabang::where('kode_cabang', 'PST')->first();
        $lokasi = explode(',', $cabang->lokasi_cabang);
        $data['latitude'] = $lokasi[0];
        $data['longitude'] = $lokasi[1];
        // if (!empty($presensi->lokasi_cabang)) {
        //     $lokasi = explode(',', $presensi->lokasi_cabang);
        //     $data['latitude'] = $lokasi[0];
        //     $data['longitude'] = $lokasi[1];
        // } else {
        //     $data['latitude'] = $cabang->latitude_cabang;
        //     $data['longitude'] = $cabang->longitude_cabang;
        // }
        $data['presensi'] = $presensi;
        $data['status'] = $status;
        $data['cabang'] = $cabang;

        return view('presensi.show', $data);
    }


    public function getdatamesin(Request $request)
    {
        $tanggal = $request->tanggal;
        $pin = $request->pin;
        // $kode_jadwal = $request->kode_jadwal;
        // if ($kode_jadwal == "JD004") {
        //     $nextday = date('Y-m-d', strtotime('+1 day', strtotime($tanggal)));
        // } else {
        //     $nextday =  $tanggal;
        // }
        $specific_value = $pin;


        //Mesin 1
        $url = 'https://developer.fingerspot.io/api/get_attlog';
        $data = '{"trans_id":"1", "cloud_id":"C2609075E32F282D", "start_date":"' . $tanggal . '", "end_date":"' . $tanggal . '"}';
        $authorization = "Authorization: Bearer QNBCLO9OA0AWILQD";

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json', $authorization));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        $result = curl_exec($ch);
        curl_close($ch);
        $res = json_decode($result);
        $datamesin1 = $res->data;

        $filtered_array = array_filter($datamesin1, function ($obj) use ($specific_value) {
            return $obj->pin == $specific_value;
        });


        //Mesin 2
        // $url = 'https://developer.fingerspot.io/api/get_attlog';
        // $data = '{"trans_id":"1", "cloud_id":"C268909557211236", "start_date":"' . $tanggal . '", "end_date":"' . $tanggal . '"}';
        // $authorization = "Authorization: Bearer QNBCLO9OA0AWILQD";

        // $ch = curl_init($url);
        // curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        // curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        // curl_setopt($ch, CURLOPT_POST, 1);
        // curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        // curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json', $authorization));
        // curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        // curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        // $result2 = curl_exec($ch);
        // curl_close($ch);
        // $res2 = json_decode($result2);
        // $datamesin2 = $res2->data;

        // $filtered_array_2 = array_filter($datamesin2, function ($obj) use ($specific_value) {
        //     return $obj->pin == $specific_value;
        // });


        return view('presensi.getdatamesin', compact('filtered_array'));
    }


    public function edit(Request $request)
    {
        $npp = Crypt::decrypt($request->npp);
        $tanggal = $request->tanggal;

        $karyawan = Karyawan::where('npp', $npp)->first();
        $jam_kerja = Jamkerja::all();
        $presensi = Presensi::where('npp', $npp)->where('tanggal', $tanggal)->first();
        $data['presensi'] = $presensi;
        $data['karyawan'] = $karyawan;
        $data['jam_kerja'] = $jam_kerja;
        $data['tanggal'] = $tanggal;

        return view('presensi.edit', $data);
    }



    public function update(Request $request)
    {
        $request->validate([
            'npp' => 'required',
            'tanggal' => 'required',
            'kode_jam_kerja' => 'required',
            'status' => 'required',
        ]);

        $npp = Crypt::decrypt($request->npp);
        $tanggal = $request->tanggal;
        $kode_jam_kerja = $request->kode_jam_kerja;
        $jam_in = $request->jam_in;
        $jam_out = $request->jam_out;
        $status = $request->status;

        try {
            $cekpresensi = Presensi::where('npp', $npp)->where('tanggal', $tanggal)->first();
            if (!empty($cekpresensi)) {
                Presensi::where('npp', $npp)->where('tanggal', $tanggal)->update([
                    'jam_in' => $jam_in,
                    'jam_out' => $jam_out,
                    'status' => $status,
                    'kode_jam_kerja' => $kode_jam_kerja,
                ]);
            } else {
                Presensi::create([
                    'npp' => $npp,
                    'tanggal' => $tanggal,
                    'jam_in' => $jam_in,
                    'jam_out' => $jam_out,
                    'kode_jam_kerja' => $kode_jam_kerja,
                    'status' => $status
                ]);
            }

            return Redirect::back()->with(messageSuccess('Data Berhasil Disimpan'));
        } catch (\Exception $e) {
            return Redirect::back()->with(messageError($e->getMessage()));
        }
    }

    public function updatefrommachine(Request $request, $pin, $status_scan)
    {
        $pin = Crypt::decrypt($request->pin);
        $karyawan       = Karyawan::where('pin', $pin)->first();

        if ($karyawan == null) {
            return response()->json([
                'status' => false,
                'message' => 'Karyawan Tidak Ditemukan',
            ]);
            $npp = "";
        } else {
            $npp = $karyawan->npp;
        }
        $scan = $request->scan_date;
        $tanggal_sekarang   = date("Y-m-d", strtotime($scan));
        $jam_sekarang = date("H:i", strtotime($scan));
        $tanggal_kemarin = date("Y-m-d", strtotime("-1 days"));

        $tanggal_besok = date("Y-m-d", strtotime("+1 days"));

        //Cek Presensi Kemarin
        $presensi_kemarin = Presensi::where('npp', $karyawan->npp)
            ->join('konfigurasi_jam_kerja', 'presensi.kode_jam_kerja', '=', 'konfigurasi_jam_kerja.kode_jam_kerja')
            ->where('npp', $karyawan->npp)
            ->where('tanggal', $tanggal_kemarin)->first();

        $lintas_hari = $presensi_kemarin ? $presensi_kemarin->lintashari : 0;

        //Jika Presensi Kemarin Status Lintas Hari nya 1 Makan Tanggal Presensi Sekarang adalah Tanggal Kemarin
        $tanggal_presensi = $lintas_hari == 1 ? $tanggal_kemarin : $tanggal_sekarang;
        $tanggal_pulang = $lintas_hari == 1 ? $tanggal_besok : $tanggal_sekarang;


        $namahari = getnamaHari(date('D', strtotime($tanggal_presensi)));
        //Cek Jam Kerja By Date
        $jamkerja = Setjamkerjabydate::join('konfigurasi_jam_kerja', 'presensi_jamkerja_bydate.kode_jam_kerja', '=', 'konfigurasi_jam_kerja.kode_jam_kerja')
            ->where('npp', $karyawan->npp)
            ->where('tanggal', $tanggal_presensi)
            ->first();

        //Jika Tidak Memiliki Jam Kerja By Date
        if ($jamkerja == null) {
            //Cek Jam Kerja harian / Jam Kerja Khusus / Jam Kerja Per Orangannya
            $jamkerja = Setjamkerjabyday::join('konfigurasi_jam_kerja', 'presensi_jamkerja_byday.kode_jam_kerja', '=', 'konfigurasi_jam_kerja.kode_jam_kerja')
                ->where('npp', $karyawan->npp)->where('hari', $namahari)->first();

            // Jika Jam Kerja Harian Kosong
            if ($jamkerja == null) {
                $jamkerja = Jamkerja::where('kode_jam_kerja', 'JK01')->first();
            }
        }

        //Cek Presensi
        $presensi = Presensi::where('npp', $karyawan->npp)->where('tanggal', $tanggal_presensi)->first();

        if ($presensi != null && $presensi->status != 'h') {
            return response()->json([
                'status' => false,
                'message' => 'Presensi Sudah Ada',
            ]);
        } else if ($jamkerja == null) {
            return response()->json([
                'status' => false,
                'message' => 'Jam Kerja Tidak Ditemukan',
            ]);
        }

        $kode_jam_kerja = $jamkerja->kode_jam_kerja;
        $jam_kerja = Jamkerja::where('kode_jam_kerja', $kode_jam_kerja)->first();

        $jam_presensi = $tanggal_sekarang . " " . $jam_sekarang;

        $jam_masuk = $tanggal_presensi . " " . date('H:i', strtotime($jam_kerja->jam_masuk));

        $presensi_hariini = Presensi::where('npp', $karyawan->npp)
            ->where('tanggal', $tanggal_presensi)
            ->first();

        if (in_array($status_scan, [0, 2, 4, 6, 8])) {
            if ($presensi_hariini && $presensi_hariini->jam_in != null) {
                return response()->json(['status' => false, 'message' => 'Anda Sudah Absen Masuk Hari Ini', 'notifikasi' => 'notifikasi_sudahabsen'], 400);
            } else {
                try {
                    if ($presensi_hariini != null) {
                        Presensi::where('id', $presensi_hariini->id)->update([
                            'jam_in' => $jam_presensi,
                        ]);
                    } else {
                        Presensi::create([
                            'npp' => $karyawan->npp,
                            'tanggal' => $tanggal_presensi,
                            'jam_in' => $jam_presensi,
                            'jam_out' => null,
                            'lokasi_out' => null,
                            'foto_out' => null,
                            'kode_jam_kerja' => $kode_jam_kerja,
                            'status' => 'h'
                        ]);
                    }


                    return Redirect::back()->with(messageSuccess('Berhasil Absen Masuk'));
                } catch (\Exception $e) {
                    return Redirect::back()->with(messageError($e->getMessage()));
                }
            }
        } else {
            try {
                if ($presensi_hariini != null) {
                    Presensi::where('id', $presensi_hariini->id)->update([
                        'jam_out' => $jam_presensi,
                    ]);
                } else {
                    Presensi::create([
                        'npp' => $karyawan->npp,
                        'tanggal' => $tanggal_presensi,
                        'jam_in' => null,
                        'jam_out' => $jam_presensi,
                        'lokasi_in' => null,
                        'foto_in' => null,
                        'kode_jam_kerja' => $kode_jam_kerja,
                        'status' => 'h'
                    ]);
                }
                return Redirect::back()->with(messageSuccess('Berhasil Absen Pulang'));
            } catch (\Exception $e) {
                return Redirect::back()->with(messageError($e->getMessage()));
            }
        }
    }
}
