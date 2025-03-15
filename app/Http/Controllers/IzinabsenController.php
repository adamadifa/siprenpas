<?php

namespace App\Http\Controllers;

use App\Models\Approveizinabsen;
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
use Jenssegers\Agent\Agent;

class IzinabsenController extends Controller
{
    public function index(Request $request)
    {
        $qizin = Izinabsen::query();
        $qizin->select('presensi_izinabsen.*', 'karyawan.nama_lengkap', 'jabatan.nama_jabatan', 'unit.nama_unit');
        $qizin->join('karyawan', 'presensi_izinabsen.npp', '=', 'karyawan.npp');
        $qizin->join('jabatan', 'karyawan.kode_jabatan', '=', 'jabatan.kode_jabatan');
        $qizin->join('unit', 'karyawan.kode_unit', '=', 'unit.kode_unit');


        if (!empty($request->dari) && !empty($request->sampai)) {
            $qizin->whereBetween('presensi_izinabsen.tanggal', [$request->dari, $request->sampai]);
        }
        if (!empty($request->nama_lengkap)) {
            $qizin->where('karyawan.nama_lengkap', 'like', '%' . $request->nama_lengkap . '%');
        }

        if (!empty($request->status) || $request->status === '0') {
            $qizin->where('presensi_izinabsen.status', $request->status);
        }
        $qizin->orderBy('presensi_izinabsen.status');
        $qizin->orderBy('presensi_izinabsen.tanggal', 'desc');
        $izinabsen = $qizin->paginate(15);
        $izinabsen->appends($request->all());

        $data['izinabsen'] = $izinabsen;
        $data['unit'] = Unit::orderBy('kode_unit')->get();
        return view('msdm.izinabsen.index', $data);
    }


    public function create()
    {
        $user = User::where('id', '=', auth()->user()->id)->first();
        $agent = new Agent();
        if ($user->hasRole('karyawan')) {
            return view('msdm.izinabsen.create-mobile');
        }
        $user = User::where('id', '=', auth()->user()->id)->first();
        $qkaryawan = Karyawan::query();
        $qkaryawan->select('karyawan.npp', 'karyawan.nama_lengkap');
        $karyawan = $qkaryawan->get();
        $data['karyawan'] = $karyawan;


        return view('msdm.izinabsen.create', $data);
    }


    public function store(Request $request)
    {
        $user = User::findorfail(auth()->user()->id);
        $userkaryawan = Userkaryawan::where('id_user', $user->id)->first();
        $role = $user->getRoleNames()->first();

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
            $jmlhari = hitungHari($request->dari, $request->sampai);
            if ($jmlhari > 3) {
                return Redirect::back()->with(messageError('Tidak Boleh Lebih dari 3 Hari!'));
            }

            $cek_izin_absen = Izinabsen::where('npp', $npp)
                ->whereBetween('dari', [$request->dari, $request->sampai])
                ->orWhereBetween('sampai', [$request->dari, $request->sampai])->first();

            $cek_izin_sakit = Izinsakit::where('npp', $npp)
                ->whereBetween('dari', [$request->dari, $request->sampai])
                ->orWhereBetween('sampai', [$request->dari, $request->sampai])->first();
            // $cek_izin_sakit = Izinsakit::where('nik', $nik)
            //     ->whereBetween('dari', [$request->dari, $request->sampai])
            //     ->orWhereBetween('sampai', [$request->dari, $request->sampai])->first();

            // $cek_izin_cuti = Izincuti::where('nik', $nik)
            //     ->whereBetween('dari', [$request->dari, $request->sampai])
            //     ->orWhereBetween('sampai', [$request->dari, $request->sampai])->first();

            if ($cek_izin_absen) {
                return Redirect::back()->with(messageError('Anda Sudah Mengajukan Izin Absen/Sakit/Cuti Pada Rentang Tanggal Tersebut!'));
            } else if ($cek_izin_sakit) {
                return Redirect::back()->with(messageError('Anda Sudah Mengajukan Izin Absen/Sakit/Cuti Absen Pada Rentang Tanggal Tersebut!'));
            }
            // else if ($cek_izin_cuti) {
            // //     return Redirect::back()->with(messageError('Anda Sudah Mengajukan Izin Absen/Sakit/Cuti Absen Pada Rentang Tanggal Tersebut!'));
            // // }
            $lastizin = Izinabsen::select('kode_izin')
                ->whereRaw('YEAR(dari)="' . date('Y', strtotime($request->dari)) . '"')
                ->whereRaw('MONTH(dari)="' . date('m', strtotime($request->dari)) . '"')
                ->orderBy("kode_izin", "desc")
                ->first();
            $last_kode_izin = $lastizin != null ? $lastizin->kode_izin : '';
            $kode_izin  = buatkode($last_kode_izin, "IA"  . date('ym', strtotime($request->dari)), 4);

            Izinabsen::create([
                'kode_izin' => $kode_izin,
                'npp' => $npp,
                'tanggal' => $request->dari,
                'dari' => $request->dari,
                'sampai' => $request->sampai,
                'keterangan' => $request->keterangan,
                'status' => 0,
            ]);
            DB::commit();

            if ($role == 'karyawan') {
                return Redirect::route('pengajuanizin.index')->with(messageSuccess('Data Berhasil Disimpan'));
            } else {
                return Redirect::back()->with(messageSuccess('Data Berhasil Disimpan'));
            }
        } catch (\Exception $e) {
            DB::rollBack();
            return Redirect::back()->with(messageError($e->getMessage()));
        }
    }


    public function edit($kode_izin)
    {
        $user = User::where('id', '=', auth()->user()->id)->first();
        $kode_izin = Crypt::decrypt($kode_izin);
        $izinabsen = Izinabsen::where('kode_izin', $kode_izin)->first();
        $qkaryawan = Karyawan::query();
        $qkaryawan->select('karyawan.npp', 'karyawan.nama_lengkap');
        $karyawan = $qkaryawan->get();
        $data['karyawan'] = $karyawan;
        $data['izinabsen'] = $izinabsen;

        return view('msdm.izinabsen.edit', $data);
    }


    public function update(Request $request, $kode_izin)
    {
        $kode_izin = Crypt::decrypt($kode_izin);
        $request->validate([
            'npp' => 'required',
            'dari' => 'required',
            'sampai' => 'required',
            'keterangan' => 'required',
        ]);
        DB::beginTransaction();
        try {
            Izinabsen::where('kode_izin', $kode_izin)->update([
                'npp' => $request->npp,
                'dari' => $request->dari,
                'sampai' => $request->sampai,
                'keterangan' => $request->keterangan
            ]);
            DB::commit();
            return Redirect::back()->with(messageSuccess('Data Berhasil Disimpan'));
        } catch (\Exception $e) {
            DB::rollBack();
            return Redirect::back()->with(messageError($e->getMessage()));
        }
    }


    public function show($kode_izin)
    {
        $kode_izin = Crypt::decrypt($kode_izin);
        $izinabsen = Izinabsen::where('kode_izin', $kode_izin)
            ->join('karyawan', 'presensi_izinabsen.npp', '=', 'karyawan.npp')
            ->join('jabatan', 'karyawan.kode_jabatan', '=', 'jabatan.kode_jabatan')
            ->join('unit', 'karyawan.kode_unit', '=', 'unit.kode_unit')
            ->first();
        $data['izinabsen'] = $izinabsen;
        return view('msdm.izinabsen.show', $data);
    }


    public function destroy($kode_izin)
    {
        $kode_izin = Crypt::decrypt($kode_izin);
        try {
            Izinabsen::where('kode_izin', $kode_izin)->delete();
            return Redirect::back()->with(messageSuccess('Data Berhasil Dihapus'));
        } catch (\Exception $e) {
            return Redirect::back()->with(messageError($e->getMessage()));
        }
    }


    public function approve($kode_izin)
    {
        $kode_izin = Crypt::decrypt($kode_izin);
        $izinabsen = Izinabsen::where('kode_izin', $kode_izin)
            ->join('karyawan', 'presensi_izinabsen.npp', '=', 'karyawan.npp')
            ->join('jabatan', 'karyawan.kode_jabatan', '=', 'jabatan.kode_jabatan')
            ->join('unit', 'karyawan.kode_unit', '=', 'unit.kode_unit')
            ->first();
        $data['izinabsen'] = $izinabsen;

        return view('msdm.izinabsen.approve', $data);
    }

    public function storeapprove(Request $request, $kode_izin)
    {
        $kode_izin = Crypt::decrypt($kode_izin);
        $izinabsen = Izinabsen::where('kode_izin', $kode_izin)
            ->join('karyawan', 'presensi_izinabsen.npp', '=', 'karyawan.npp')
            ->first();
        $dari = $izinabsen->dari;
        $sampai = $izinabsen->sampai;
        $npp = $izinabsen->npp;
        $kode_dept = $izinabsen->kode_dept;
        $error = '';
        DB::beginTransaction();
        try {
            while (strtotime($dari) <= strtotime($sampai)) {

                //Cek Jadwal Pada Setiap tanggal
                $namahari = getnamaHari(date('D', strtotime($dari)));

                $jamkerja = Setjamkerjabydate::join('konfigurasi_jam_kerja', 'presensi_jamkerja_bydate.kode_jam_kerja', '=', 'konfigurasi_jam_kerja.kode_jam_kerja')
                    ->where('npp', $izinabsen->npp)
                    ->where('tanggal', $dari)
                    ->first();
                if ($jamkerja == null) {
                    $jamkerja = Setjamkerjabyday::join('konfigurasi_jam_kerja', 'presensi_jamkerja_byday.kode_jam_kerja', '=', 'konfigurasi_jam_kerja.kode_jam_kerja')
                        ->where('npp', $izinabsen->npp)->where('hari', $namahari)
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
                            'status' => 'i',
                        ]);

                        Approveizinabsen::create([
                            'id_presensi' => $presensi->id,
                            'kode_izin' => $kode_izin,
                        ]);

                        Izinabsen::where('kode_izin', $kode_izin)->update([
                            'status' => 1
                        ]);
                    } else {
                        Izinabsen::where('kode_izin', $kode_izin)->update([
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
        $presensi = Approveizinabsen::where('kode_izin', $kode_izin)->get();
        try {
            Izinabsen::where('kode_izin', $kode_izin)->update([
                'status' => 0
            ]);
            Approveizinabsen::where('kode_izin', $kode_izin)->delete();
            Presensi::whereIn('id', $presensi->pluck('id_presensi'))->delete();
            return Redirect::back()->with(messageSuccess('Data Berhasil Disimpan'));
        } catch (\Exception $e) {
            return Redirect::back()->with(messageError($e->getMessage()));
        }
    }
}
