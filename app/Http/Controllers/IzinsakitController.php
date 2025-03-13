<?php

namespace App\Http\Controllers;

use App\Models\Approveizinsakit;
use App\Models\Izinabsen;
use App\Models\Izinsakit;
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
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;

class IzinsakitController extends Controller
{
    public function index(Request $request)
    {
        $qizin = Izinsakit::query();
        $qizin->select('presensi_izinsakit.*', 'karyawan.nama_lengkap', 'jabatan.nama_jabatan', 'unit.nama_unit');
        $qizin->join('karyawan', 'presensi_izinsakit.npp', '=', 'karyawan.npp');
        $qizin->join('jabatan', 'karyawan.kode_jabatan', '=', 'jabatan.kode_jabatan');
        $qizin->join('unit', 'karyawan.kode_unit', '=', 'unit.kode_unit');


        if (!empty($request->dari) && !empty($request->sampai)) {
            $qizin->whereBetween('presensi_izinsakit.tanggal', [$request->dari, $request->sampai]);
        }
        if (!empty($request->nama_lengkap)) {
            $qizin->where('karyawan.nama_lengkap', 'like', '%' . $request->nama_lengkap . '%');
        }

        if (!empty($request->status) || $request->status === '0') {
            $qizin->where('presensi_izinsakit.status', $request->status);
        }
        $qizin->orderBy('presensi_izinsakit.status');
        $qizin->orderBy('presensi_izinsakit.tanggal', 'desc');
        $izinsakit = $qizin->paginate(15);
        $izinsakit->appends($request->all());

        $data['izinsakit'] = $izinsakit;
        $data['unit'] = Unit::orderBy('kode_unit')->get();
        return view('msdm.izinsakit.index', $data);
    }


    public function create()
    {
        $user = User::where('id', '=', auth()->user()->id)->first();
        $qkaryawan = Karyawan::query();
        $qkaryawan->select('karyawan.npp', 'karyawan.nama_lengkap');
        $karyawan = $qkaryawan->get();

        $data['karyawan'] = $karyawan;

        if ($user->hasRole('karyawan')) {
            return view('msdm.izinsakit.create-mobile', $data);
        }

        return view('msdm.izinsakit.create', $data);
    }

    public function store(Request $request)
    {
        $user = User::findorfail(auth()->user()->id);
        $role = $user->getRoleNames()->first();
        $userkaryawan = Userkaryawan::where('id_user', $user->id)->first();
        $npp = $user->hasRole('karyawan') ? $userkaryawan->npp : $request->npp;
        if ($role == 'karyawan') {
            $request->validate([
                'dari' => 'required',
                'sampai' => 'required',
                'keterangan' => 'required',
            ]);
        } else {
            $request->validate([
                'npp' => 'required',
                'dari' => 'required',
                'sampai' => 'required',
                'keterangan' => 'required',
            ]);
        }

        DB::beginTransaction();
        try {
            $cek_izin_absen = Izinabsen::where('npp', $npp)
                ->whereBetween('dari', [$request->dari, $request->sampai])
                ->orWhereBetween('sampai', [$request->dari, $request->sampai])->first();

            $cek_izin_sakit = Izinsakit::where('npp', $npp)
                ->whereBetween('dari', [$request->dari, $request->sampai])
                ->orWhereBetween('sampai', [$request->dari, $request->sampai])->first();

            // $cek_izin_cuti = Izincuti::where('npp', $npp)
            //     ->whereBetween('dari', [$request->dari, $request->sampai])
            //     ->orWhereBetween('sampai', [$request->dari, $request->sampai])->first();

            if ($cek_izin_absen) {
                return Redirect::back()->with(messageError('Anda Sudah Mengajukan Izin Absen/Sakit/Cuti Pada Rentang Tanggal Tersebut!'));
            } else if ($cek_izin_sakit) {
                return Redirect::back()->with(messageError('Anda Sudah Mengajukan Izin Absen/Sakit/Cuti Absen Pada Rentang Tanggal Tersebut!'));
            }
            // else if ($cek_izin_cuti) {
            //     return Redirect::back()->with(messageError('Anda Sudah Mengajukan Izin Absen/Sakit/Cuti Absen Pada Rentang Tanggal Tersebut!'));
            // }
            $lastizinsakit = Izinsakit::select('kode_izin_sakit')
                ->whereRaw('YEAR(tanggal)="' . date('Y', strtotime($request->dari)) . '"')
                ->whereRaw('MONTH(tanggal)="' . date('m', strtotime($request->dari)) . '"')
                ->orderBy("kode_izin_sakit", "desc")
                ->first();
            $last_kode_izin_sakit = $lastizinsakit != null ? $lastizinsakit->kode_izin_sakit : '';
            $kode_izin_sakit  = buatkode($last_kode_izin_sakit, "IS"  . date('ym', strtotime($request->dari)), 4);


            $data_sid = [];
            if ($request->hasfile('sid')) {
                $sid_name =  $kode_izin_sakit . "." . $request->file('sid')->getClientOriginalExtension();
                $destination_sid_path = "/public/uploads/sid";
                $sid = $sid_name;
                $data_sid = [
                    'doc_sid' => $sid,
                ];
            }

            $dataizinsakit = [
                'kode_izin_sakit' => $kode_izin_sakit,
                'npp' => $npp,
                'tanggal' => $request->dari,
                'dari' => $request->dari,
                'sampai' => $request->sampai,
                'keterangan' => $request->keterangan,
                'status' => 0,
                'id_user' => $user->id,
            ];

            $data = array_merge($dataizinsakit, $data_sid);
            $simpandatasakit = Izinsakit::create($data);
            if ($simpandatasakit) {
                if ($request->hasfile('sid')) {
                    $request->file('sid')->storeAs($destination_sid_path, $sid_name);
                }
            }
            DB::commit();
            return Redirect::back()->with(messageSuccess('Data Berhasil Disimpan'));
        } catch (\Exception $e) {
            DB::rollBack();
            return Redirect::back()->with(messageError($e->getMessage()));
        }
    }


    public function approve($kode_izin)
    {
        $kode_izin = Crypt::decrypt($kode_izin);
        $izinsakit = Izinsakit::where('kode_izin_sakit', $kode_izin)
            ->join('karyawan', 'presensi_izinsakit.npp', '=', 'karyawan.npp')
            ->join('jabatan', 'karyawan.kode_jabatan', '=', 'jabatan.kode_jabatan')
            ->join('unit', 'karyawan.kode_unit', '=', 'unit.kode_unit')
            ->first();
        $data['izinsakit'] = $izinsakit;

        return view('msdm.izinsakit.approve', $data);
    }

    public function storeapprove(Request $request, $kode_izin)
    {
        $kode_izin = Crypt::decrypt($kode_izin);
        $izinsakit = Izinsakit::where('kode_izin_sakit', $kode_izin)
            ->join('karyawan', 'presensi_izinsakit.npp', '=', 'karyawan.npp')
            ->first();
        $dari = $izinsakit->dari;
        $sampai = $izinsakit->sampai;
        $npp = $izinsakit->npp;
        $kode_dept = $izinsakit->kode_dept;
        $error = '';
        DB::beginTransaction();
        try {
            while (strtotime($dari) <= strtotime($sampai)) {

                //Cek Jadwal Pada Setiap tanggal
                $namahari = getnamaHari(date('D', strtotime($dari)));

                $jamkerja = Setjamkerjabydate::join('konfigurasi_jam_kerja', 'presensi_jamkerja_bydate.kode_jam_kerja', '=', 'konfigurasi_jam_kerja.kode_jam_kerja')
                    ->where('npp', $izinsakit->npp)
                    ->where('tanggal', $dari)
                    ->first();
                if ($jamkerja == null) {
                    $jamkerja = Setjamkerjabyday::join('konfigurasi_jam_kerja', 'presensi_jamkerja_byday.kode_jam_kerja', '=', 'konfigurasi_jam_kerja.kode_jam_kerja')
                        ->where('npp', $izinsakit->npp)->where('hari', $namahari)
                        ->first();
                }

                if ($jamkerja == null) {
                    $jamkerja = Jamkerja::where('kode_jam_kerja', 'JK01')->first();
                }

                if ($jamkerja == null) {
                    $error .= 'Jam Kerja pada Tanggal ' . $dari . ' Belum Di Set! <br>';
                } else {
                    // dd($request->all());
                    // dd(isset($request->approve));
                    if (isset($request->approve)) {
                        // echo 'test';
                        $presensi = Presensi::create([
                            'npp' => $npp,
                            'tanggal' => $dari,
                            'kode_jam_kerja' => $jamkerja->kode_jam_kerja,
                            'status' => 's',
                        ]);

                        Approveizinsakit::create([
                            'id_presensi' => $presensi->id,
                            'kode_izin_sakit' => $kode_izin,
                        ]);

                        Izinsakit::where('kode_izin_sakit', $kode_izin)->update([
                            'status' => 1
                        ]);
                    } else {
                        Izinsakit::where('kode_izin_sakit', $kode_izin)->update([
                            'status' => 2
                        ]);
                    }
                }


                $dari = date('Y-m-d', strtotime($dari . ' +1 day'));
            }
            if (!empty($error)) {
                DB::rollBack();
                return Redirect::back()->with(messageError($error));
            }
            DB::commit();
            return Redirect::back()->with(messageSuccess('Data Berhasil Disimpan'));
        } catch (\Exception $e) {
            DB::rollBack();
            return Redirect::back()->with(messageError($e->getMessage()));
        }
    }

    public function cancelapprove($kode_izin)
    {
        $kode_izin = Crypt::decrypt($kode_izin);
        $presensi = Approveizinsakit::where('kode_izin_sakit', $kode_izin)->get();
        try {
            Izinsakit::where('kode_izin_sakit', $kode_izin)->update([
                'status' => 0
            ]);
            Approveizinsakit::where('kode_izin_sakit', $kode_izin)->delete();
            Presensi::whereIn('id', $presensi->pluck('id_presensi'))->delete();
            return Redirect::back()->with(messageSuccess('Data Berhasil Disimpan'));
        } catch (\Exception $e) {
            return Redirect::back()->with(messageError($e->getMessage()));
        }
    }

    public function show($kode_izin)
    {
        $kode_izin = Crypt::decrypt($kode_izin);
        $izinsakit = Izinsakit::where('kode_izin_sakit', $kode_izin)
            ->join('karyawan', 'presensi_izinsakit.npp', '=', 'karyawan.npp')
            ->join('jabatan', 'karyawan.kode_jabatan', '=', 'jabatan.kode_jabatan')
            ->join('unit', 'karyawan.kode_unit', '=', 'unit.kode_unit')
            ->first();
        $data['izinsakit'] = $izinsakit;
        return view('msdm.izinsakit.show', $data);
    }


    public function edit($kode_izin)
    {
        $user = User::where('id', '=', auth()->user()->id)->first();
        $kode_izin = Crypt::decrypt($kode_izin);
        $izinsakit = Izinsakit::where('kode_izin_sakit', $kode_izin)->first();
        $qkaryawan = Karyawan::query();
        $qkaryawan->select('karyawan.npp', 'karyawan.nama_lengkap');
        $karyawan = $qkaryawan->get();
        $data['karyawan'] = $karyawan;
        $data['izinsakit'] = $izinsakit;

        return view('msdm.izinsakit.edit', $data);
    }

    public function update(Request $request, $kode_izin_sakit)
    {
        $kode_izin_sakit = Crypt::decrypt($kode_izin_sakit);

        $request->validate([
            'npp' => 'required',
            'dari' => 'required',
            'sampai' => 'required',
            'keterangan' => 'required',
        ]);
        DB::beginTransaction();
        try {
            $izinsakit = Izinsakit::where('kode_izin_sakit', $kode_izin_sakit)->first();
            $data_sid = [];
            if ($request->hasfile('sid')) {
                $sid_name =  $kode_izin_sakit . "." . $request->file('sid')->getClientOriginalExtension();
                $destination_sid_path = "/public/uploads/sid";
                $sid = $sid_name;
                $data_sid = [
                    'doc_sid' => $sid,
                ];
            }

            $dataizinsakit = [
                'npp' => $request->npp,
                'tanggal' => $request->dari,
                'dari' => $request->dari,
                'sampai' => $request->sampai,
                'keterangan' => $request->keterangan,

            ];

            $data = array_merge($dataizinsakit, $data_sid);

            $simpandatasakit = Izinsakit::where('kode_izin_sakit', $kode_izin_sakit)->update($data);
            if ($simpandatasakit) {
                if ($request->hasfile('sid')) {
                    Storage::delete($destination_sid_path . "/" . $izinsakit->doc_sid);
                    $request->file('sid')->storeAs($destination_sid_path, $sid_name);
                }
            }
            DB::commit();
            return Redirect::back()->with(messageSuccess('Data Berhasil Disimpan'));
        } catch (\Exception $e) {
            DB::rollBack();
            return Redirect::back()->with(messageError($e->getMessage()));
        }
    }


    public function destroy($kode_izin_sakit)
    {
        $kode_izin_sakit = Crypt::decrypt($kode_izin_sakit);
        try {
            Izinsakit::where('kode_izin_sakit', $kode_izin_sakit)->delete();
            return Redirect::back()->with(messageSuccess('Data Berhasil Dihapus'));
        } catch (\Exception $e) {
            return Redirect::back()->with(messageError($e->getMessage()));
        }
    }
}
